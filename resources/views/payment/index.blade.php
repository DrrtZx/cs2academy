@extends('layouts.app')
@section('title', 'Pembayaran')

@push('styles')
<style>
.pay-wrap{max-width:560px;margin:0 auto;padding:4rem 2rem;}
.pay-card{background:var(--bg2);border:1px solid var(--border);border-radius:18px;overflow:hidden;}
.pay-summary{background:linear-gradient(135deg,var(--bg3),var(--bg4));border-bottom:1px solid var(--border);padding:1.4rem 1.75rem;display:flex;justify-content:space-between;align-items:center;}
.pay-btn{width:100%;background:var(--grad-primary);color:#fff;border:none;padding:13px;border-radius:11px;font-size:0.95rem;font-weight:800;cursor:pointer;box-shadow:0 10px 24px -10px rgba(139,123,255,.65);transition:all .2s;}
.pay-btn:hover{filter:brightness(1.08);transform:translateY(-1px);}
.va-box{background:var(--bg3);border:2px dashed var(--purple);border-radius:12px;padding:1rem 1.25rem;text-align:center;margin-bottom:1.25rem;}
.va-number{font-size:1.6rem;font-weight:800;color:var(--purple2);letter-spacing:2px;word-break:break-all;}
.va-label{font-size:0.72rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.4rem;}
.step-item{display:flex;gap:12px;margin-bottom:0.9rem;}
.step-num{width:26px;height:26px;background:rgba(124,111,224,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.72rem;font-weight:700;color:var(--purple2);flex-shrink:0;margin-top:1px;}
.step-text{font-size:0.84rem;color:var(--text2);line-height:1.6;}
.step-text strong{color:var(--text);}
</style>
@endpush

@section('content')
<div class="pay-wrap">
  <div style="text-align:center;margin-bottom:1.75rem;">
    <div style="font-size:2rem;margin-bottom:.5rem;">🏦</div>
    <h2 style="font-size:1.5rem;font-weight:800;margin-bottom:.35rem;">Pembayaran BCA Virtual Account</h2>
    <p style="color:var(--text2);font-size:.875rem;">Selesaikan pembayaran dalam <strong>1×24 jam</strong> sebelum pesanan otomatis kedaluwarsa</p>
  </div>

  <div class="pay-card">
    <div class="pay-summary">
      <div>
        <div style="font-weight:700;font-size:0.95rem;">{{ $layanan }}</div>
        <div style="font-size:0.75rem;color:var(--text2);margin-top:2px;">CS2 Coaching Session</div>
      </div>
      <div style="font-size:1.6rem;font-weight:800;color:var(--purple2);">{{ $harga }}</div>
    </div>

    <div style="padding:1.5rem;">
      {{-- Virtual Account Info --}}
      <div class="va-box">
        <div class="va-label">BCA Virtual Account Number</div>
        <div class="va-number" id="vaDisplay">{{ $vaPreview }}</div>
        <div style="margin-top:0.6rem;">
          <span style="font-size:0.75rem;color:var(--text3);">a.n. <strong style="color:var(--text);">CS2 Academy</strong></span>
        </div>
      </div>

      {{-- Cara Pembayaran --}}
      <div style="margin-bottom:1.25rem;">
        <div style="font-size:0.72rem;font-weight:700;color:var(--text2);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.8rem;">Cara Pembayaran</div>

        <div style="margin-bottom:0.2rem;font-size:0.78rem;font-weight:700;color:var(--text);">🏧 via BCA Mobile / myBCA</div>
        <div class="step-item">
          <div class="step-num">1</div>
          <div class="step-text">Buka aplikasi <strong>myBCA</strong> atau <strong>BCA Mobile</strong></div>
        </div>
        <div class="step-item">
          <div class="step-num">2</div>
          <div class="step-text">Pilih menu <strong>Pembayaran</strong> → <strong>Virtual Account</strong></div>
        </div>
        <div class="step-item">
          <div class="step-num">3</div>
          <div class="step-text">Masukkan nomor Virtual Account: <strong id="vaStep">{{ $vaPreview }}</strong></div>
        </div>
        <div class="step-item">
          <div class="step-num">4</div>
          <div class="step-text">Konfirmasi nominal <strong>{{ $harga }}</strong> dan pilih sumber rekening</div>
        </div>
        <div class="step-item">
          <div class="step-num">5</div>
          <div class="step-text">Masukkan PIN myBCA/BCA Mobile dan tekan <strong>Kirim</strong></div>
        </div>

        <details style="margin-top:0.8rem;cursor:pointer;">
          <summary style="font-size:0.78rem;color:var(--purple2);font-weight:600;">🔄 Alternatif via KlikBCA / ATM</summary>
          <div style="margin-top:0.6rem;padding-left:0;">
            <div class="step-item">
              <div class="step-num" style="background:rgba(0,212,170,0.15);color:var(--green);">A</div>
              <div class="step-text"><strong>KlikBCA:</strong> Pembayaran → VA → input VA number → Konfirmasi</div>
            </div>
            <div class="step-item">
              <div class="step-num" style="background:rgba(0,212,170,0.15);color:var(--green);">B</div>
              <div class="step-text"><strong>ATM BCA:</strong> Transaksi Lainnya → Pembayaran → BCA VA → masukkan VA number</div>
            </div>
          </div>
        </details>
      </div>

      {{-- Konfirmasi --}}
      <form method="POST" action="{{ route('payment.store') }}">
        @csrf
        <input type="hidden" name="package_name"  value="{{ $layanan }}">
        <input type="hidden" name="package_price" value="{{ $harga }}">
        <div style="background:rgba(255,140,66,0.08);border:1px solid rgba(255,140,66,0.25);border-radius:10px;padding:0.75rem 1rem;margin-bottom:1rem;font-size:0.78rem;color:var(--orange);display:flex;gap:8px;align-items:flex-start;">
          <span style="font-size:1rem;flex-shrink:0;">⏱️</span>
          <span>Setelah klik konfirmasi, lakukan pembayaran maksimal <strong>1×24 jam</strong>.
            Admin akan memverifikasi setelah dana masuk.</span>
        </div>
        <button type="submit" class="pay-btn">🏦 Konfirmasi & Lihat Virtual Account</button>
      </form>

      <a href="{{ route('coaching') }}" style="display:block;width:100%;text-align:center;background:transparent;color:var(--text2);border:1px solid var(--border);padding:9px;border-radius:9px;font-size:0.85rem;margin-top:10px;">← Kembali ke Paket Coaching</a>
    </div>
  </div>
 </div>
@endsection
