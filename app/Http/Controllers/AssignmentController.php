<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    // Tampilkan daftar tugas milik user yang login
    public function index()
    {
        $assignments = Assignment::where('user_id', auth()->id())
                                 ->latest()
                                 ->get();
        return view('assignments.index', compact('assignments'));
    }

    // Simpan tugas baru dari user
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