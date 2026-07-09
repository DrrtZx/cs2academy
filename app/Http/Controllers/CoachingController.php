<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoachingController extends Controller
{
    public function index()
    {
        return view('coaching.index');
    }

    public function payment(Request $request)
    {
        // Route ini sudah dibungkus middleware 'auth' di routes/web.php
        $layanan = $request->query('layanan', 'Textual Review');
        $harga   = $request->query('harga', 'Rp 100.000');
        return view('payment.index', compact('layanan', 'harga'));
    }

    public function confirmPayment(Request $request)
    {
        // Tandai user sudah bayar
        auth()->user()->update(['has_paid' => true]);
        return redirect()->route('payment.success');
    }

    public function success()
    {
        return view('payment.success');
    }
}
