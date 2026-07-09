<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            // Total user yang sudah terdaftar (role = user)
            'total_players'     => User::where('role', 'user')->count(),

            // Total kursus yang tersedia di platform
            'total_courses'     => Course::count(),

            // Total sesi kursus yang berhasil diselesaikan oleh semua user
            'total_completions' => CourseProgress::whereNotNull('completed_at')->count(),

            // Total request coaching yang masuk (semua status)
            'total_coaching'    => Assignment::count(),
        ];

        return view('home', compact('stats'));
    }
}