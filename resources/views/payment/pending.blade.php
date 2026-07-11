@extends('layouts.app')
@section('title', 'Menunggu Pembayaran')

@push('styles')
<style>
.pay-wrap{max-width:560px;margin:0 auto;padding:4rem 2rem;}
.va-card{background:var(--bg2);border:1px solid var(--border);border-radius:18px;overflow:hidden;margin-bottom:1.5rem;}
.va-header{background:linear-gradient(135deg,var(--bg3),var(--bg4));border-bottom:1px solid var(--border);padding:1.25rem 1.5rem;text-align:center;}
.va-big{font-size:1.8rem;font-weight:800;color:var(--purple2);letter-spacing:2px;word-break:break-all;margin-top:0.5rem;}
.va-body{padding:1.25rem 1.5rem;}
.va-label{font-size:0.7rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.35rem;}
.va-row{display:flex;justify-content:space-between;align-items:center;padding:0.6rem 0;border-bottom:1px solid var(--border);}
.va-row:last-child{border-bottom:none;}
.copy-btn{background:rgba(124,111,224,0.12);color:var(--purple2);border:1px solid rgba(124,111,224,0.25);padding:6px 14px;border-radius:8px;font-size:0.78rem;font-weight:600;cursor:pointer;transition:all .2s;}
.copy-btn:hover{background:rgba(124,111,224,0.22);}
.copy-btn.copied{background:rgba(0,212,170,0.15);color:var(--green);border-color:rgba(0,212,170,0.3);}
.step-card{background:var(--bg2);border:1px solid var(--border);border-radius:16px;padding:1.25rem 1.5rem;margin-bottom:1rem;}
.step-title{font-size:0.82rem;font-weight:700;margin-bottom:0.75rem;}
.step-item{display:flex;gap:12px;margin-bottom:0.8rem;}
.step-num{width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:700;flex-shrink:0;margin-top:2px;}
.step-text{font-size:0.84rem;color:var(--text2);line-height:1.6;}
.step-text strong{color:var(--text);}
.status-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:50px;font-size:0.78rem;font-weight:700;}
.status-pending{background:rgba(255,140,66,0.15);color:var(--orange);}
</style>
@endpush

@section('content')
<div class="pay-wrap">

  {{-- Header --}}
  <div style="text-align:center;margin-bottom:1.75rem;">
    <div style="font-size:2.5rem;margin-bottom:0.5rem;">🏦</div>
    <h2 style="font-size:1.5rem;font-weight:800;margin-bottom:0.35rem;">Pembayaran via BCA Virtual Account</h2>
    <p style="color:var(--text2);font-size:0.85rem;">Lakukan transfer ke VA di bawah ini sebelum batas waktu</p>
  </div>

  {{-- VA Info Card --}}
  <div class="va-card">
    <div class="va-header">
      <div style="font-size:0.72rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:0.5px;">BCA Virtual Account Number</div>
      <div class="va-big" id="vaCode">{{ $transaction->va_code ?? '—' }}</div>
      <button class="copy-btn" id="copyBtn" onclick="copyVa()">📋 Salin Virtual Account</button>
    </div>

    <div class="va-body">
      <div class="va-row">
        <div>
          <div class="va-label">Paket</div>
          <div style="font-weight:700;font-size:0.9rem;">{{ $transaction->package_name }}</div>
        </div>
        <div style="font-size:1.2rem;font-weight:800;color:var(--purple2);">{{ $transaction->package_price }}</div>
      </div>
      <div class="va-row">
        <div>
          <div class="va-label">Nama Penerima</div>
          <div style="font-weight:600;font-size:0.9rem;">CS2 Academy</div>
        </div>
        <span class="status-badge status-pending">⏳ Menunggu Pembayaran</span>
      </div>
      <div class="va-row">
        <div>
          <div class="va-label">Batas Waktu</div>
          <div style="font-size:0.85rem;color:var(--orange);font-weight:600;">24 jam sejak {{ $transaction->created_at->diffForHumans() }}</div>
        </div>
      </div>
    </div>
  </div>

  {{-- Cara Bayar --}}
  <div class="step-card">
    <div class="step-title">🏧 Cara Bayar via myBCA / BCA Mobile</div>
    <div class="step-item">
      <div class="step-num" style="background:rgba(124,111,224,0.15);color:var(--purple2);">1</div>
      <div class="step-text">Login ke aplikasi <strong>myBCA</strong> atau <strong>BCA Mobile</strong></div>
    </div>
    <div class="step-item">
      <div class="step-num" style="background:rgba(124,111,224,0.15);color:var(--purple2);">2</div>
      <div class="step-text">Pilih menu <strong>Pembayaran</strong> → <strong>Virtual Account</strong></div>
    </div>
    <div class="step-item">
      <div class="step-num" style="background:rgba(124,111,224,0.15);color:var(--purple2);">3</div>
      <div class="step-text">Masukkan nomor VA: <strong>{{ $transaction->va_code ?? '—' }}</strong></div>
    </div>
    <div class="step-item">
      <div class="step-num" style="background:rgba(124,111,224,0.15);color:var(--purple2);">4</div>
      <div class="step-text">Pastikan nominal <strong>{{ $transaction->package_price }}</strong> dan rekening tujuan benar</div>
    </div>
    <div class="step-item">
      <div class="step-num" style="background:rgba(124,111,224,0.15);color:var(--purple2);">5</div>
      <div class="step-text">Masukkan PIN lalu pilih <strong>Kirim</strong></div>
    </div>
  </div>

  <details style="margin-bottom:1.5rem;cursor:pointer;">
    <summary style="font-size:0.82rem;color:var(--purple2);font-weight:600;padding:0.5rem 0;">🔄 Alternatif via KlikBCA / ATM</summary>
    <div style="margin-top:0.8rem;padding:1rem;background:var(--bg3);border-radius:12px;">
      <div class="step-item">
        <div class="step-num" style="background:rgba(0,212,170,0.15);color:var(--green);">A</div>
        <div class="step-text"><strong>KlikBCA:</strong> Masuk → Pembayaran & Transfer → Pembayaran → BCA Virtual Account → input VA → Konfirmasi</div>
      </div>
      <div class="step-item">
        <div class="step-num" style="background:rgba(0,212,170,0.15);color:var(--green);">B</div>
        <div class="step-text"><strong>ATM BCA:</strong> Transaksi Lainnya → Pembayaran → BCA Virtual Account → masukkan VA number → Bayar</div>
      </div>
    </div>
  </details>

  {{-- Setelah Bayar --}}
  <div style="background:rgba(43,230,186,0.06);border:1px solid rgba(43,230,186,0.2);border-radius:14px;padding:1.25rem 1.5rem;margin-bottom:1.5rem;">
    <div style="display:flex;gap:10px;align-items:flex-start;">
      <span style="font-size:1.3rem;flex-shrink:0;">✅</span>
      <div>
        <div style="font-weight:700;font-size:0.9rem;margin-bottom:0.3rem;">Setelah Transfer Berhasil</div>
        <p style="font-size:0.82rem;color:var(--text2);line-height:1.7;">
          Pembayaran akan diverifikasi oleh admin secara manual dalam <strong>1×24 jam</strong> kerja.
          Kamu akan mendapat notifikasi setelah sesi coaching aktif.
        </p>
      </div>
    </div>
  </div>

  {{-- Actions --}}
  <a href="{{ route('home') }}" style="display:block;width:100%;padding:13px;border-radius:12px;font-size:0.95rem;font-weight:700;background:var(--grad-primary);color:#fff;border:none;margin-bottom:10px;text-align:center;box-shadow:0 10px 24px -10px rgba(139,123,255,.6);">🏠 Kembali ke Beranda</a>
  <a href="{{ route('coaching') }}" style="display:block;width:100%;padding:13px;border-radius:12px;font-size:0.95rem;font-weight:700;background:transparent;color:var(--text);border:1px solid var(--border);text-align:center;">🎮 Lihat Paket Coaching</a>
</div>

@push('scripts')
<script>
function copyVa() {
  var va = document.getElementById('vaCode');
  var btn = document.getElementById('copyBtn');
  if (!va) return;
  var text = va.textContent.trim();
  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(text).then(function() {
      btn.textContent = '✅ Tersalin!';
      btn.classList.add('copied');
      setTimeout(function() { btn.textContent = '📋 Salin Virtual Account'; btn.classList.remove('copied'); }, 2500);
    });
  } else {
    // Fallback
    var range = document.createRange();
    range.selectNodeContents(va);
    var sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);
    document.execCommand('copy');
    sel.removeAllRanges();
    btn.textContent = '✅ Tersalin!';
    btn.classList.add('copied');
    setTimeout(function() { btn.textContent = '📋 Salin Virtual Account'; btn.classList.remove('copied'); }, 2500);
  }
}
</script>
@endpush
