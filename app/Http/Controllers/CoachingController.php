<?php

namespace App\Http\Controllers;

use App\Models\CoachingTransaction;
use Illuminate\Http\Request;

class CoachingController extends Controller
{
    public function index()
    {
        return view('coaching.index');
    }

    public function payment(Request $request)
    {
        $layanan = $request->query('layanan', 'Textual Review');
        $harga   = $request->query('harga', 'Rp 100.000');

        if (auth()->user()->hasPendingCoaching()) {
            return redirect()->route('coaching')->with(
                'error',
                '⚠️ Kamu masih punya sesi coaching yang aktif atau sedang menunggu verifikasi. Selesaikan sesi tersebut terlebih dahulu sebelum memesan yang baru.'
            );
        }

        // Generate dummy VA code preview (final VA dibuat pas store)
        $vaPreview = $this->generateVaCode(auth()->id(), 0);

        return view('payment.index', compact('layanan', 'harga', 'vaPreview'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_name'  => 'required|string|max:255',
            'package_price' => 'required|string|max:50',
        ]);

        if (auth()->user()->hasPendingCoaching()) {
            return redirect()->route('coaching')->with(
                'error',
                '⚠️ Kamu sudah punya sesi coaching yang sedang berjalan atau menunggu verifikasi.'
            );
        }

        $transaction = CoachingTransaction::create([
            'user_id'       => auth()->id(),
            'package_name'  => $request->package_name,
            'package_price' => $request->package_price,
            'va_code'       => null,
            'status'        => 'pending',
        ]);

        // Generate VA code setelah transaksi tersimpan (butuh ID)
        $transaction->update([
            'va_code' => $this->generateVaCode(auth()->id(), $transaction->id),
        ]);

        return redirect()->route('payment.pending');
    }

    public function pendingStatus()
    {
        $transaction = auth()->user()
            ->coachingTransactions()
            ->whereIn('status', ['pending', 'approved'])
            ->latest()
            ->first();

        if (! $transaction) {
            return redirect()->route('coaching')
                ->with('error', 'Tidak ada transaksi aktif yang ditemukan.');
        }

        if ($transaction->status === 'approved') {
            return redirect()->route('assignments.index')
                ->with('success', '✅ Pembayaran kamu sudah dikonfirmasi! Sesi coaching kamu sudah aktif.');
        }

        return view('payment.pending', compact('transaction'));
    }

    public function success()
    {
        return view('payment.success');
    }

    public function uploadBukti(Request $request)
    {
        $request->validate([
            'bukti' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // max 2MB
        ], [
            'bukti.required' => 'File bukti transfer wajib diupload.',
            'bukti.mimes' => 'Format file harus JPG, PNG, atau PDF.',
            'bukti.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $transaction = auth()->user()
            ->coachingTransactions()
            ->whereIn('status', ['pending', 'approved'])
            ->latest()
            ->first();

        if (!$transaction) {
            return back()->with('error', 'Tidak ada transaksi aktif yang ditemukan.');
        }

        if ($transaction->status === 'approved') {
            return back()->with('error', 'Pembayaran sudah disetujui. Upload bukti tidak diperlukan lagi.');
        }

        // Hapus file lama jika ada
        if ($transaction->bukti_transfer) {
            $oldPath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'bukti-transfer' . DIRECTORY_SEPARATOR . $transaction->bukti_transfer);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Upload file baru
        $file = $request->file('bukti');
        $extension = $file->getClientOriginalExtension();
        $filename = 'user' . auth()->id() . '_trx' . $transaction->id . '_' . time() . '.' . $extension;
        
        // Upload file baru ke disk public
        $file->storeAs('bukti-transfer', $filename, 'public');

        // Update database
        $transaction->update([
            'bukti_transfer' => $filename,
            'bukti_uploaded_at' => now(),
        ]);

        return back()->with('success', '✅ Bukti transfer berhasil diupload! Admin akan memverifikasi pembayaran Anda.');
    }

    public function checkPaymentStatus()
    {
        $transaction = auth()->user()
            ->coachingTransactions()
            ->whereIn('status', ['pending', 'approved'])
            ->latest()
            ->first();

        if (!$transaction) {
            return response()->json(['status' => 'none', 'reload' => false]);
        }

        return response()->json([
            'status' => $transaction->status,
            'reload' => $transaction->status === 'approved',
            'message' => $transaction->status === 'approved' 
                ? '✅ Pembayaran Anda telah disetujui!' 
                : null,
        ]);
    }

    private function generateVaCode(int $userId, int $transactionId): string
    {
        // Format: 8808 (BCA VA prefix) + 5 digit user ID + 6 digit transaction ID = 15 digit
        $userPart = str_pad($userId, 5, '0', STR_PAD_LEFT);
        $txPart   = str_pad($transactionId, 6, '0', STR_PAD_LEFT);
        return '8808' . $userPart . $txPart;
    }

    /**
     * Serve bukti transfer files directly from storage (bypasses symlink 403).
     */
    public function serveBukti(string $filename)
    {
        // Sanitize filename to prevent directory traversal
        $filename = basename($filename);

        // Try public disk first (Laravel 11+: storage/app/public)
        $publicPath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'bukti-transfer' . DIRECTORY_SEPARATOR . $filename);
        // Fallback: legacy private path (storage/app/private/public)
        $privatePath = storage_path('app' . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'bukti-transfer' . DIRECTORY_SEPARATOR . $filename);

        $fullPath = file_exists($publicPath) ? $publicPath : (file_exists($privatePath) ? $privatePath : null);

        if (!$fullPath) {
            abort(404, 'File tidak ditemukan.');
        }

        $mimeType = mime_content_type($fullPath) ?: 'application/octet-stream';

        return response()->file($fullPath, [
            'Content-Type'        => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }
}
