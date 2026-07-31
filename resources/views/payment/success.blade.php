@extends('layouts.app')
@section('title', 'Pembayaran Berhasil Dikonfirmasi')

@push('styles')
<style>
.pay-success-wrap {
    max-width: 640px;
    margin: 0 auto;
    padding: 3.5rem 1.5rem;
}
.success-hero-card {
    background: var(--bg2);
    border: 1px solid rgba(0, 212, 170, 0.3);
    border-radius: 24px;
    padding: 2.5rem 2rem;
    text-align: center;
    box-shadow: 0 20px 60px rgba(0, 212, 170, 0.08), 0 0 0 1px rgba(0, 212, 170, 0.15);
    position: relative;
    overflow: hidden;
}
.success-hero-card::before {
    content: '';
    position: absolute;
    top: -100px;
    left: 50%;
    transform: translateX(-50%);
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(0, 212, 170, 0.15) 0%, rgba(0, 0, 0, 0) 70%);
    pointer-events: none;
}
.success-icon-badge {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(0, 212, 170, 0.2), rgba(0, 212, 170, 0.05));
    border: 2px solid var(--green);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem auto;
    box-shadow: 0 0 30px rgba(0, 212, 170, 0.35);
    animation: success-pulse 2s infinite alternate ease-in-out;
}
@keyframes success-pulse {
    0% { transform: scale(1); box-shadow: 0 0 25px rgba(0, 212, 170, 0.3); }
    100% { transform: scale(1.06); box-shadow: 0 0 45px rgba(0, 212, 170, 0.5); }
}
.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(0, 212, 170, 0.12);
    border: 1px solid rgba(0, 212, 170, 0.3);
    color: var(--green);
    font-size: 0.78rem;
    font-weight: 700;
    padding: 4px 14px;
    border-radius: 50px;
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.status-pill .dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--green);
    box-shadow: 0 0 8px var(--green);
}
.receipt-box {
    background: var(--bg3);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    margin: 1.75rem 0;
    text-align: left;
}
.receipt-header {
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--text3);
    text-transform: uppercase;
    letter-spacing: 0.6px;
    margin-bottom: 0.75rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid var(--border);
}
.receipt-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    font-size: 0.85rem;
}
.receipt-label { color: var(--text2); }
.receipt-val { font-weight: 700; color: var(--text); }
.steps-container {
    background: rgba(124, 111, 224, 0.05);
    border: 1px solid rgba(124, 111, 224, 0.18);
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.75rem;
    text-align: left;
}
.steps-title {
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--purple2);
    margin-bottom: 0.9rem;
    display: flex;
    align-items: center;
    gap: 6px;
}
.step-item-s {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 0.75rem;
}
.step-item-s:last-child { margin-bottom: 0; }
.step-num-s {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: rgba(139, 123, 255, 0.2);
    color: var(--purple2);
    font-size: 0.72rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
}
.step-txt-s {
    font-size: 0.83rem;
    color: var(--text2);
    line-height: 1.5;
}
.step-txt-s strong { color: var(--text); }
.btn-cta-primary {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 14px 20px;
    border-radius: 12px;
    font-size: 0.95rem;
    font-weight: 700;
    background: var(--grad-primary);
    color: #fff;
    text-decoration: none;
    box-shadow: 0 10px 28px -8px rgba(139, 123, 255, 0.65);
    transition: all .2s ease;
    margin-bottom: 10px;
}
.btn-cta-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 34px -6px rgba(139, 123, 255, 0.75);
}
.btn-cta-secondary {
    display: block;
    width: 100%;
    padding: 12px 20px;
    border-radius: 12px;
    font-size: 0.88rem;
    font-weight: 600;
    background: transparent;
    color: var(--text2);
    border: 1px solid var(--border);
    text-decoration: none;
    transition: all .2s;
}
.btn-cta-secondary:hover {
    color: var(--text);
    border-color: rgba(255,255,255,0.2);
}
</style>
@endpush

@section('content')
<div class="pay-success-wrap">
  <div class="success-hero-card">
    
    {{-- Icon Badge --}}
    <div class="success-icon-badge">
      <x-cs-icon name="check" size="40" stroke="3" style="color:var(--green);" />
    </div>

    {{-- Status Pill --}}
    <div class="status-pill">
      <span class="dot"></span> Pembayaran Dikonfirmasi
    </div>

    <h2 style="font-size:1.65rem;font-weight:800;margin-bottom:0.5rem;color:var(--text);">
      Pembayaran Berhasil! 🎉
    </h2>
    <p style="color:var(--text2);font-size:0.88rem;line-height:1.6;max-width:480px;margin:0 auto;">
      Sip! Pembayaran kamu telah diverifikasi oleh Admin. Sesi coaching kamu kini <strong style="color:var(--green);">sudah aktif</strong> dan siap digunakan.
    </p>

    {{-- Receipt Detail Card --}}
    @if(isset($transaction) && $transaction)
    <div class="receipt-box">
      <div class="receipt-header">Rincian Transaksi Coaching</div>
      <div class="receipt-row">
        <span class="receipt-label">Paket Coaching</span>
        <span class="receipt-val" style="color:var(--purple2);">{{ $transaction->package_name }}</span>
      </div>
      <div class="receipt-row">
        <span class="receipt-label">Nominal Pembayaran</span>
        <span class="receipt-val">{{ $transaction->package_price }}</span>
      </div>
      <div class="receipt-row">
        <span class="receipt-label">Nomor Virtual Account</span>
        <span class="receipt-val">{{ $transaction->va_code ?? '-' }}</span>
      </div>
      <div class="receipt-row">
        <span class="receipt-label">Status Verifikasi</span>
        <span class="receipt-val" style="color:var(--green);">✅ Disetujui Admin</span>
      </div>
      <div class="receipt-row">
        <span class="receipt-label">Waktu Konfirmasi</span>
        <span class="receipt-val">{{ $transaction->updated_at ? $transaction->updated_at->format('d M Y, H:i') : '-' }} WIB</span>
      </div>
    </div>
    @endif

    {{-- Next steps guidance --}}
    <div class="steps-container">
      <div class="steps-title">
        <x-cs-icon name="zap" size="14" stroke="2" /> Langkah Selanjutnya:
      </div>
      <div class="step-item-s">
        <div class="step-num-s">1</div>
        <div class="step-txt-s">Buka menu <strong>Tugas Saya</strong> untuk melihat pesan sambutan dari Coach.</div>
      </div>
      <div class="step-item-s">
        <div class="step-num-s">2</div>
        <div class="step-txt-s">Kirimkan detail pertanyaan, ID Discord, atau link video match CS2 kamu.</div>
      </div>
      <div class="step-item-s">
        <div class="step-num-s">3</div>
        <div class="step-txt-s">Coach CS2 Academy akan meninjau & memberikan feedback langsung.</div>
      </div>
    </div>

    {{-- CTAs --}}
    <a href="{{ route('assignments.index') }}" class="btn-cta-primary">
      <x-cs-icon name="message-square" size="18" stroke="2" /> Mulai Chat Sesi Coaching Sekarang
    </a>
    <a href="{{ route('home') }}" class="btn-cta-secondary">
      Kembali ke Beranda
    </a>

  </div>
</div>
@endsection
