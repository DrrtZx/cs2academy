<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /** Halaman tugas user: sesi aktif + arsip */
    public function index()
    {
        $userId = auth()->id();

        $activeSessions = Assignment::where('user_id', $userId)
            ->where('status', '!=', 'selesai')
            ->latest()
            ->get();

        $archivedSessions = Assignment::where('user_id', $userId)
            ->where('status', 'selesai')
            ->orderBy('created_at')
            ->get();

        return view('assignments.index', compact('activeSessions', 'archivedSessions'));
    }

    /** Kirim balasan dari user */
    public function reply(Request $request, Assignment $assignment)
    {
        if ($assignment->user_id !== auth()->id()) abort(403);
        if ($assignment->status === 'selesai') {
            return response()->json(['error' => 'Sesi ini sudah selesai.'], 403);
        }

        $request->validate(['message' => 'required|string']);

        $assignment->messages()->create([
            'sender_id' => auth()->id(),
            'message'   => $request->message,
        ]);

        $assignment->update(['status' => 'diproses', 'updated_at' => now()]);

        $msg = $assignment->messages()->latest('id')->first();

        return response()->json([
            'success'  => true,
            'message'  => [
                'id'       => $msg->id,
                'sender'   => 'Kamu',
                'message'  => $msg->message,
                'is_admin' => false,
                'time'     => $msg->created_at->format('H:i'),
                'time_ago' => $msg->created_at->diffForHumans(),
            ],
        ]);
    }

    /** JSON: semua pesan dalam 1 sesi + status sesi */
    public function messages(Assignment $assignment)
    {
        if ($assignment->user_id !== auth()->id()) abort(403);

        // Mark pesan dari admin sebagai read
        $assignment->messages()
            ->where('sender_id', '!=', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $msgs = $assignment->messages()->get()->map(function ($msg) use ($assignment) {
            $isUser = $msg->sender_id === auth()->id();
            return [
                'id'       => $msg->id,
                'sender'   => $isUser ? 'Kamu' : 'Coach / Admin',
                'message'  => $msg->message,
                'is_admin' => !$isUser,
                'time'     => $msg->created_at->format('H:i'),
                'time_ago' => $msg->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'messages'  => $msgs,
            'status'    => $assignment->status,
            'is_closed' => $assignment->status === 'selesai',
        ]);
    }
}
