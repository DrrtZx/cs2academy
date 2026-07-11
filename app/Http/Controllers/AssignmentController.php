<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Tampilkan halaman tugas user, dibagi menjadi sesi aktif dan arsip selesai.
     */
    public function index()
    {
        $userId = auth()->id();

        // Sesi aktif: belum selesai (menunggu atau diproses)
        $activeSessions = Assignment::where('user_id', $userId)
            ->where('status', '!=', 'selesai')
            ->latest()
            ->get();

        // Arsip: sesi yang sudah selesai (diurutkan ascending untuk timeline)
        $archivedSessions = Assignment::where('user_id', $userId)
            ->where('status', 'selesai')
            ->orderBy('created_at')
            ->get();

        return view('assignments.index', compact('activeSessions', 'archivedSessions'));
    }

    /**
     * Simpan tugas baru dari user (hanya bisa jika has_paid).
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'      => 'required|string|max:255',
            'tugas_teks' => 'required|string',
        ]);

        Assignment::create([
            'user_id'    => auth()->id(),
            'judul'      => $request->judul,
            'tugas_teks' => $request->tugas_teks,
            'status'     => 'menunggu',
        ]);

        return back()->with('success', 'Tugas berhasil dikirim! Admin akan segera mereview.');
    }
}