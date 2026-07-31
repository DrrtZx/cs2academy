@extends('layouts.app')
@section('title', 'Menunggu Konfirmasi')

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

/* Modal — unique prefix bup- to avoid layout JS conflicts */
.bup-overlay{display:none;position:fixed;inset:0;background:rgba(5,7,15,0.82);z-index:10000;align-items:center;justify-content:center;backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);}
.bup-overlay.bup-open{display:flex;}
.bup-box{background:var(--bg2);border:1px solid var(--border);border-radius:20px;width:min(560px,94vw);max-height:92vh;overflow:hidden;display:flex;flex-direction:column;box-shadow:0 32px 80px rgba(0,0,0,0.65),0 0 0 1px rgba(255,255,255,0.05);}
.bup-head{padding:1.1rem 1.4rem;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-shrink:0;background:linear-gradient(135deg,var(--bg3),var(--bg4));}
.bup-head h3{font-size:1rem;font-weight:800;margin:0;display:flex;align-items:center;gap:8px;}
.bup-close{width:32px;height:32px;border-radius:9px;background:rgba(255,255,255,0.06);border:1px solid var(--border);color:var(--text2);font-size:1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .2s;line-height:1;}
.bup-close:hover{background:rgba(255,80,80,0.15);color:#ff5f5f;border-color:rgba(255,80,80,0.3);}
.bup-body{overflow-y:auto;padding:1.25rem;flex:1;min-height:0;}
.bup-img-wrap{border-radius:12px;overflow:hidden;border:1px solid var(--border);background:var(--bg3);}
.bup-img-wrap img{display:block;width:100%;height:auto;}
</style>
@endpush

@section('content')
<div class="pay-wrap">

  @if(session('success'))
    <div style="background:rgba(0,212,170,0.12);border:1px solid rgba(0,212,170,0.3);border-radius:10px;padding:0.9rem 1.25rem;margin-bottom:1.25rem;font-size:0.875rem;color:var(--green);font-weight:600;">{{ session('success') }}</div>
  @endif

  @if(session('error'))
    <div style="background:rgba(255,80,80,0.1);border:1px solid rgba(255,80,80,0.3);border-radius:10px;padding:0.9rem 1.25rem;margin-bottom:1.25rem;font-size:0.875rem;color:#ff5f5f;font-weight:600;">{{ session('error') }}</div>
  @endif

  {{-- Header --}}
  <div style="text-align:center;margin-bottom:1.75rem;">
    <h2 style="font-size:1.5rem;font-weight:800;margin-bottom:0.35rem;">Pembayaran via BCA Virtual Account</h2>
    <p style="color:var(--text2);font-size:0.85rem;">Lakukan transfer ke VA di bawah ini sebelum batas waktu</p>
  </div>

  {{-- VA Info Card --}}
  <div class="va-card">
    <div class="va-header">
      <div style="font-size:0.72rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:0.5px;">BCA Virtual Account Number</div>
      <div class="va-big" id="vaCode">{{ $transaction->va_code ?? '—' }}</div>
      <button class="copy-btn" id="copyBtn" onclick="copyVa()">Salin Virtual Account</button>
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
        <span class="status-badge status-pending">Menunggu Konfirmasi</span>
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
    <div class="step-title">Cara Bayar via myBCA / BCA Mobile</div>
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
    <summary style="font-size:0.82rem;color:var(--purple2);font-weight:600;padding:0.5rem 0;">Alternatif via KlikBCA / ATM</summary>
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
    <div>
      <div style="font-weight:700;font-size:0.9rem;margin-bottom:0.3rem;">Setelah Transfer Berhasil</div>
      <p style="font-size:0.82rem;color:var(--text2);line-height:1.7;">
        Pembayaran akan diverifikasi oleh admin secara manual dalam <strong>1×24 jam</strong> kerja.
        Kamu akan mendapat notifikasi setelah sesi coaching aktif.
      </p>
    </div>
  </div>

  {{-- Upload Bukti Transfer --}}
  <div class="step-card" style="border:2px dashed rgba(124,111,224,0.3);">
    <div class="step-title" style="margin-bottom:1rem;">
      Upload Bukti Transfer
    </div>
    
    @if($transaction->bukti_transfer)
      <div style="background:rgba(0,212,170,0.1);border:1px solid rgba(0,212,170,0.3);border-radius:10px;padding:1rem;margin-bottom:1rem;">
        <div style="margin-bottom:8px;">
          <span style="font-weight:700;font-size:0.88rem;color:var(--green);">Bukti sudah diupload</span>
        </div>
        @if($transaction->bukti_uploaded_at)
          <div style="font-size:0.78rem;color:var(--text2);">
            Diupload pada: {{ $transaction->bukti_uploaded_at->format('d M Y H:i') }}
          </div>
        @endif
        <button type="button" onclick="bupOpen()" style="display:inline-block;margin-top:8px;background:var(--grad-primary);color:#fff;border:none;padding:8px 16px;border-radius:8px;font-size:0.82rem;font-weight:600;cursor:pointer;box-shadow:0 4px 12px -4px rgba(139,123,255,.4);transition:all .2s;">
          Lihat Bukti Transfer
        </button>
      </div>
    @endif

    <form method="POST" action="{{ route('payment.upload') }}" enctype="multipart/form-data" id="uploadForm">
      @csrf
      <div style="margin-bottom:1rem;">
        <label style="display:block;font-size:0.8rem;font-weight:700;color:var(--text2);margin-bottom:8px;">
          Pilih File Bukti Transfer (JPG/PNG/PDF, max 2MB)
        </label>
        <input type="file" name="bukti" accept=".jpg,.jpeg,.png,.pdf" required
          style="display:block;width:100%;padding:10px;border:1px solid var(--border);border-radius:10px;font-size:0.85rem;background:var(--bg3);">
      </div>

      @error('bukti')
        <div style="background:rgba(255,80,80,0.1);border:1px solid rgba(255,80,80,0.3);border-radius:8px;padding:8px 12px;margin-bottom:1rem;font-size:0.8rem;color:#ff5f5f;">
          {{ $message }}
        </div>
      @enderror

      <button type="submit" style="width:100%;padding:12px;border-radius:10px;font-size:0.9rem;font-weight:700;background:var(--grad-primary);color:#fff;border:none;cursor:pointer;box-shadow:0 8px 20px -8px rgba(139,123,255,.5);">
        Upload Bukti Transfer
      </button>
    </form>

    <p style="font-size:0.75rem;color:var(--text3);margin-top:0.8rem;line-height:1.6;">
      Upload screenshot/foto bukti transfer untuk mempercepat verifikasi pembayaran oleh admin.
    </p>
  </div>

  {{-- Actions --}}
  <a href="{{ route('home') }}" style="display:block;width:100%;padding:13px;border-radius:12px;font-size:0.95rem;font-weight:700;background:var(--grad-primary);color:#fff;border:none;margin-bottom:10px;text-align:center;box-shadow:0 10px 24px -10px rgba(139,123,255,.6);">Kembali ke Beranda</a>
  <a href="{{ route('coaching') }}" style="display:block;width:100%;padding:13px;border-radius:12px;font-size:0.95rem;font-weight:700;background:transparent;color:var(--text);border:1px solid var(--border);text-align:center;">Lihat Paket Coaching</a>
</div>

{{-- Modal Bukti Transfer (bup- prefix to avoid JS conflicts) --}}
@if($transaction->bukti_transfer)
@php
  $ext2 = strtolower(pathinfo($transaction->bukti_transfer, PATHINFO_EXTENSION));
  $isImg2 = in_array($ext2, ['jpg','jpeg','png']);
@endphp
<div class="bup-overlay" id="bupModal">
  <div class="bup-box">
    <div class="bup-head">
      <h3>Bukti Transfer</h3>
      <button class="bup-close" onclick="bupClose()" title="Tutup">✕</button>
    </div>
    <div class="bup-body">
      {{-- Info strip --}}
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;padding-bottom:0.75rem;border-bottom:1px solid var(--border);">
        <div>
          <div style="font-size:0.65rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:0.6px;">Paket</div>
          <div style="font-size:0.88rem;font-weight:600;">{{ $transaction->package_name }}</div>
        </div>
        <div style="text-align:right;">
          <div style="font-size:0.65rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:0.6px;">Diupload</div>
          <div style="font-size:0.78rem;font-weight:600;color:var(--text2);">
            {{ $transaction->bukti_uploaded_at ? $transaction->bukti_uploaded_at->format('d M Y H:i') : '—' }}
          </div>
        </div>
      </div>
      {{-- Image / PDF --}}
      @if($isImg2)
        <div class="bup-img-wrap">
          <img src="{{ url('/storage/bukti-transfer/' . $transaction->bukti_transfer) }}"
            alt="Bukti Transfer"
            onerror="this.parentElement.innerHTML='<div style=\'padding:2rem;text-align:center;color:#ff5f5f;\'>Gambar tidak dapat dimuat</div>';">
        </div>
        <div style="margin-top:8px;text-align:right;">
          <a href="{{ url('/storage/bukti-transfer/' . $transaction->bukti_transfer) }}" target="_blank"
            style="font-size:0.75rem;color:var(--purple2);text-decoration:none;">Buka di tab baru →</a>
        </div>
      @else
        <div style="text-align:center;padding:2rem;">
          <p style="font-size:0.9rem;color:var(--text2);margin-bottom:1rem;">Bukti transfer dalam format PDF</p>
          <a href="{{ url('/storage/bukti-transfer/' . $transaction->bukti_transfer) }}" target="_blank"
            style="display:inline-block;background:var(--grad-primary);color:#fff;padding:10px 20px;border-radius:10px;font-size:0.9rem;font-weight:700;text-decoration:none;">
            Download PDF
          </a>
        </div>
      @endif
    </div>
  </div>
</div>
@endif

@push('scripts')
<script>
function copyVa() {
  var va = document.getElementById('vaCode');
  var btn = document.getElementById('copyBtn');
  if (!va) return;
  var text = va.textContent.trim();
  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(text).then(function() {
      btn.textContent = 'Tersalin!';
      btn.classList.add('copied');
      setTimeout(function() { btn.textContent = 'Salin Virtual Account'; btn.classList.remove('copied'); }, 2500);
    });
  } else {
    var range = document.createRange();
    range.selectNodeContents(va);
    var sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);
    document.execCommand('copy');
    sel.removeAllRanges();
    btn.textContent = 'Tersalin!';
    btn.classList.add('copied');
    setTimeout(function() { btn.textContent = 'Salin Virtual Account'; btn.classList.remove('copied'); }, 2500);
  }
}

// Bukti Transfer Modal (unique function names — no conflict with layout's closeModal)
function bupOpen() {
  var modal = document.getElementById('bupModal');
  if (modal) {
    modal.classList.add('bup-open');
    document.body.style.overflow = 'hidden';
  }
}

function bupClose() {
  var modal = document.getElementById('bupModal');
  if (modal) {
    modal.classList.remove('bup-open');
    document.body.style.overflow = '';
  }
}

var bupModal = document.getElementById('bupModal');
if (bupModal) {
  bupModal.addEventListener('click', function(e) {
    if (e.target === this) bupClose();
  });
}

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') bupClose();
});

// Auto-refresh polling setiap 30 detik
let lastStatus = '{{ $transaction->status }}';
setInterval(function() {
  fetch('{{ route("payment.check") }}')
    .then(res => res.json())
    .then(data => {
      if (data.reload && data.status !== lastStatus) {
        if (data.message) { alert(data.message); }
        window.location.href = '{{ route("assignments.index") }}';
      }
    })
    .catch(err => console.error('Polling error:', err));
}, 30000);
</script>
@endpush
