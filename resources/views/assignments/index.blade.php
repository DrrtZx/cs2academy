@extends('layouts.app')
@section('title', 'Tugas Saya')

@push('styles')
<style>
.assign-wrap{max-width:800px;margin:0 auto;padding:3rem 2rem;}
.assign-card{background:var(--bg2);border:1px solid var(--border);border-radius:14px;padding:1.5rem;margin-bottom:1rem;}
.status-badge{display:inline-block;padding:3px 10px;border-radius:50px;font-size:0.72rem;font-weight:700;}
.status-menunggu{background:rgba(255,140,66,0.2);color:var(--orange);}
.status-diproses{background:rgba(79,195,247,0.2);color:var(--blue);}
.status-selesai{background:rgba(0,212,170,0.15);color:var(--green);}
.form-card{background:var(--bg2);border:1px solid var(--border);border-radius:14px;padding:1.5rem;margin-bottom:2rem;}
.f-inp{width:100%;background:var(--bg3);border:1.5px solid var(--border);color:var(--text);padding:10px 13px;border-radius:10px;font-size:0.9rem;outline:none;margin-bottom:1rem;}
.f-inp:focus{border-color:var(--purple);}
textarea.f-inp{resize:vertical;min-height:100px;}
.submit-btn{background:var(--grad-primary);color:#fff;border:none;padding:12px 24px;border-radius:10px;font-size:0.9rem;font-weight:700;cursor:pointer;width:100%;box-shadow:0 10px 24px -10px rgba(139,123,255,.65);transition:all .2s;}
.submit-btn:hover{filter:brightness(1.08);transform:translateY(-1px);}
.balasan-box{background:var(--bg3);border:1px solid var(--green);border-radius:10px;padding:1rem;margin-top:0.75rem;}
.from-admin-card{border-color:rgba(124,111,224,.4);background:rgba(124,111,224,.04);}
.badge-from-admin{display:inline-flex;align-items:center;gap:4px;font-size:0.65rem;font-weight:700;padding:3px 9px;border-radius:50px;background:rgba(124,111,224,.15);color:var(--purple2);}
</style>
@endpush

@section('content')
<div class="assign-wrap">
  <h2 style="font-size:1.5rem;font-weight:800;margin-bottom:0.5rem;">📝 Tugas & Pertanyaan Saya</h2>
  <p style="color:var(--text2);font-size:0.875rem;margin-bottom:2rem;">Kirim pertanyaan atau demo game kamu ke coach, nanti dibalas langsung di sini.</p>

  {{-- Form Kirim Tugas --}}
  <div class="form-card">
    <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem;">➕ Kirim Tugas / Pertanyaan Baru</h3>
    <form method="POST" action="{{ route('assignments.store') }}">
      @csrf
      <div style="margin-bottom:0.5rem;font-size:0.75rem;color:var(--text2);font-weight:600;text-transform:uppercase;">Judul / Topik</div>
      <input type="text" name="judul" class="f-inp" placeholder="Contoh: Pertanyaan tentang spray control AK-47" value="{{ old('judul') }}" required>
      @error('judul') <p style="color:var(--red);font-size:0.8rem;margin-top:-0.8rem;margin-bottom:0.8rem;">{{ $message }}</p> @enderror

      <div style="margin-bottom:0.5rem;font-size:0.75rem;color:var(--text2);font-weight:600;text-transform:uppercase;">Isi Pertanyaan / Link Demo</div>
      <textarea name="tugas_teks" class="f-inp" placeholder="Tuliskan pertanyaanmu secara detail, atau paste link video/demo di sini..." required>{{ old('tugas_teks') }}</textarea>
      @error('tugas_teks') <p style="color:var(--red);font-size:0.8rem;margin-top:-0.8rem;margin-bottom:0.8rem;">{{ $message }}</p> @enderror

      <button type="submit" class="submit-btn">🚀 Kirim ke Coach</button>
    </form>
  </div>

  {{-- Daftar Tugas --}}
  <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem;">📋 Riwayat Tugas</h3>

  @forelse($assignments as $item)
    <div class="assign-card {{ $item->from_admin ? 'from-admin-card' : '' }}">
      <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:0.75rem;">
        <div>
          <div style="font-weight:700;font-size:0.95rem;">{{ $item->judul }}</div>
          <div style="font-size:0.75rem;color:var(--text3);margin-top:2px;display:flex;align-items:center;gap:6px;">
            {{ $item->created_at->diffForHumans() }}
            @if($item->from_admin)
              <span class="badge-from-admin">📨 Dari Coach</span>
            @endif
          </div>
        </div>
        @if(!$item->from_admin)
        <span class="status-badge status-{{ $item->status }}">
          {{ $item->status === 'menunggu' ? '⏳ Menunggu' : ($item->status === 'diproses' ? '🔄 Diproses' : '✅ Selesai') }}
        </span>
        @endif
      </div>
      <p style="color:var(--text2);font-size:0.85rem;line-height:1.7;">{{ $item->tugas_teks }}</p>

      @if(!$item->from_admin)
        @if($item->balasan_admin)
          <div class="balasan-box">
            <div style="font-size:0.72rem;font-weight:700;color:var(--green);margin-bottom:0.4rem;">💬 BALASAN COACH/ADMIN:</div>
            <p style="font-size:0.875rem;line-height:1.7;color:var(--text);">{{ $item->balasan_admin }}</p>
          </div>
        @else
          <div style="margin-top:0.75rem;font-size:0.78rem;color:var(--text3);font-style:italic;">⏳ Belum ada balasan dari coach. Harap ditunggu ya...</div>
        @endif
      @endif
    </div>
  @empty
    <div style="text-align:center;padding:3rem;color:var(--text3);">
      <div style="font-size:3rem;margin-bottom:1rem;">📭</div>
      <p>Belum ada tugas yang dikirim. Yuk kirim pertanyaan pertamamu di form atas!</p>
    </div>
  @endforelse
</div>
@endsection
