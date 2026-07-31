@extends('layouts.app')
@section('title', 'Pembayaran Berhasil')

@section('content')
<div style="max-width:480px;margin:0 auto;text-align:center;padding:5rem 2rem;">
  <h2 style="font-size:1.8rem;font-weight:800;margin-bottom:0.9rem;">Pembayaran Berhasil!</h2>
  <p style="color:var(--text2);line-height:1.75;margin-bottom:2rem;font-size:0.9rem;">
    Sip! Pembayarannya udah masuk. Coach CS2 kamu bakal langsung masuk dalam
    <strong style="color:var(--green);">5 menit ke bawah</strong>.
    Sambil nunggu, kamu bisa langsung kirim pertanyaan atau materi yang mau di-review.
  </p>
  <a href="{{ route('home') }}" style="display:block;width:100%;padding:13px;border-radius:12px;font-size:0.95rem;font-weight:700;background:var(--grad-primary);color:#fff;border:none;margin-bottom:10px;text-align:center;box-shadow:0 10px 24px -10px rgba(139,123,255,.6);">Kembali ke Beranda</a>
  <a href="{{ route('assignments.index') }}" style="display:block;width:100%;padding:13px;border-radius:12px;font-size:0.95rem;font-weight:700;background:transparent;color:var(--text);border:1px solid var(--border);text-align:center;">Kirim Pertanyaan / Materi</a>
</div>
@endsection
