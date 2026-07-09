@extends('layouts.app')
@section('title', 'Pembayaran')

@push('styles')
<style>
.pay-wrap{max-width:540px;margin:0 auto;padding:4rem 2rem;}
.pay-card{background:var(--bg2);border:1px solid var(--border);border-radius:18px;overflow:hidden;}
.pay-summary{background:linear-gradient(135deg,var(--bg3),var(--bg4));border-bottom:1px solid var(--border);padding:1.4rem 1.75rem;display:flex;justify-content:space-between;align-items:center;}
.pm-opt{display:flex;align-items:center;gap:12px;padding:13px 15px;border-radius:11px;border:2px solid var(--border);cursor:pointer;transition:all .2s;background:var(--bg3);margin-bottom:8px;}
.pm-opt:hover,.pm-opt.sel{border-color:var(--purple);background:rgba(124,111,224,0.09);}
.pay-btn{width:100%;background:linear-gradient(135deg,var(--green) 0%,var(--cyan) 100%);color:#0d1420;border:none;padding:13px;border-radius:11px;font-size:0.95rem;font-weight:800;cursor:pointer;margin-bottom:8px;box-shadow:0 10px 24px -10px rgba(43,230,186,.55);transition:all .2s;}
.pay-btn:hover{filter:brightness(1.06);transform:translateY(-1px);}
</style>
@endpush

@section('content')
<div class="pay-wrap">
  <div style="text-align:center;margin-bottom:1.75rem;">
    <div style="font-size:2rem;margin-bottom:.5rem;">💳</div>
    <h2 style="font-size:1.5rem;font-weight:800;margin-bottom:.35rem;">Proses Pembayaran</h2>
    <p style="color:var(--text2);font-size:.875rem;">Pilih metode pembayaran</p>
  </div>
  <div class="pay-card">
    <div class="pay-summary">
      <div>
        <div style="font-weight:700;font-size:0.95rem;">{{ $layanan }}</div>
        <div style="font-size:0.75rem;color:var(--text2);margin-top:2px;">CS2 Coaching Session</div>
      </div>
      <div style="font-size:1.6rem;font-weight:800;color:var(--purple2);">{{ $harga }}</div>
    </div>
    <div style="padding:1.4rem 1.5rem 0;">
      <div style="font-size:0.7rem;font-weight:700;color:var(--text2);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.9rem;">Pilih Metode Pembayaran</div>
      <div class="pm-opt" onclick="this.classList.toggle('sel')"><div style="font-size:1.4rem;width:32px;text-align:center;">💚</div><div><div style="font-weight:700;font-size:0.9rem;">GoPay</div><div style="font-size:0.72rem;color:var(--text2);">Bayar via QRIS atau aplikasi GoPay</div></div></div>
      <div class="pm-opt" onclick="this.classList.toggle('sel')"><div style="font-size:1.4rem;width:32px;text-align:center;">💜</div><div><div style="font-weight:700;font-size:0.9rem;">OVO</div><div style="font-size:0.72rem;color:var(--text2);">Bayar via QRIS atau aplikasi OVO</div></div></div>
      <div class="pm-opt" onclick="this.classList.toggle('sel')"><div style="font-size:1.4rem;width:32px;text-align:center;">🏦</div><div><div style="font-weight:700;font-size:0.9rem;">BCA</div><div style="font-size:0.72rem;color:var(--text2);">Transfer via Virtual Account BCA</div></div></div>
    </div>
    <div style="padding:1.1rem 1.5rem 1.5rem;">
      {{-- Form POST ke route payment.confirm --}}
      <form method="POST" action="{{ route('payment.confirm') }}">
        @csrf
        <input type="hidden" name="layanan" value="{{ $layanan }}">
        <button type="submit" class="pay-btn">✓ Konfirmasi Pembayaran</button>
      </form>
      <a href="{{ route('coaching') }}" style="display:block;width:100%;text-align:center;background:transparent;color:var(--text2);border:1px solid var(--border);padding:9px;border-radius:9px;font-size:0.85rem;margin-top:8px;">← Kembali ke Coaching</a>
    </div>
  </div>
</div>
@endsection
