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

    private function generateVaCode(int $userId, int $transactionId): string
    {
        // Format: 8808 (BCA VA prefix) + 5 digit user ID + 6 digit transaction ID = 15 digit
        $userPart = str_pad($userId, 5, '0', STR_PAD_LEFT);
        $txPart   = str_pad($transactionId, 6, '0', STR_PAD_LEFT);
        return '8808' . $userPart . $txPart;
    }
}
