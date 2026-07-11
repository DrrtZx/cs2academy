@extends('layouts.app')
@section('title', 'Tugas Saya')

@push('styles')
<style>
/* ── Layout ── */
.assign-wrap { max-width: 820px; margin: 0 auto; padding: 3rem 2rem; }

/* ── Tab navigation ── */
.sess-tabs {
    display: flex;
    gap: 4px;
    background: var(--bg2);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 5px;
    margin-bottom: 1.75rem;
}
.sess-tab {
    flex: 1;
    padding: 9px 16px;
    border-radius: 10px;
    border: none;
    background: transparent;
    color: var(--text2);
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
}
.sess-tab.active {
    background: var(--grad-primary);
    color: #fff;
    box-shadow: 0 4px 14px -4px rgba(139,123,255,.55);
}
.sess-tab .tab-count {
    background: rgba(255,255,255,0.25);
    border-radius: 50px;
    padding: 1px 7px;
    font-size: 0.7rem;
    font-weight: 700;
}
.sess-tab:not(.active) .tab-count {
    background: rgba(124,111,224,0.15);
    color: var(--purple2);
}

/* ── Tab panels ── */
.sess-panel { display: none; }
.sess-panel.active { display: block; }

/* ── Assignment cards ── */
.assign-card {
    background: var(--bg2);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: border-color .2s;
}
.assign-card:hover { border-color: rgba(124,111,224,0.35); }
.assign-card.from-admin-card { border-color: rgba(124,111,224,.35); background: rgba(124,111,224,.04); }
.assign-card.archived-card { opacity: 0.85; }

/* ── Status badges ── */
.status-badge { display:inline-block; padding:3px 10px; border-radius:50px; font-size:0.72rem; font-weight:700; }
.status-menunggu { background:rgba(255,140,66,0.2); color:var(--orange); }
.status-diproses { background:rgba(79,195,247,0.2); color:var(--blue); }
.status-selesai  { background:rgba(0,212,170,0.15); color:var(--green); }

/* ── Form kirim tugas ── */
.form-card { background: var(--bg2); border: 1px solid var(--border); border-radius: 14px; padding: 1.5rem; margin-bottom: 1.5rem; }
.f-inp { width:100%; background:var(--bg3); border:1.5px solid var(--border); color:var(--text); padding:10px 13px; border-radius:10px; font-size:0.9rem; outline:none; margin-bottom:1rem; }
.f-inp:focus { border-color: var(--purple); }
textarea.f-inp { resize:vertical; min-height:100px; }
.submit-btn { background:var(--grad-primary); color:#fff; border:none; padding:12px 24px; border-radius:10px; font-size:0.9rem; font-weight:700; cursor:pointer; width:100%; box-shadow:0 10px 24px -10px rgba(139,123,255,.65); transition:all .2s; }
.submit-btn:hover { filter:brightness(1.08); transform:translateY(-1px); }

/* ── Chat Timeline ── */
.chat-timeline { position: relative; padding-left: 2rem; }
.chat-timeline::before {
    content: ''; position: absolute; left: 10px; top: 8px; bottom: 8px;
    width: 2px; background: var(--border); border-radius: 2px;
}
.chat-msg { position: relative; margin-bottom: 1.25rem; }
.chat-msg::before {
    content: ''; position: absolute; left: -1.65rem; top: 12px;
    width: 10px; height: 10px; border-radius: 50%;
    background: var(--bg2); border: 2px solid var(--border);
}
.chat-msg.chat-user::before { background: var(--purple); border-color: var(--purple); }
.chat-msg.chat-coach::before { background: var(--green); border-color: var(--green); }
.chat-bubble {
    background: var(--bg2); border: 1px solid var(--border);
    border-radius: 12px; padding: 1rem 1.25rem; transition: border-color .2s;
}
.chat-bubble:hover { border-color: rgba(124,111,224,0.3); }
.chat-bubble-header {
    font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.4px; margin-bottom: 0.4rem; display: flex;
    align-items: center; gap: 5px;
}
.chat-bubble-header.coach-header { color: var(--green); }
.chat-bubble-header.user-header { color: var(--purple2); }
.chat-bubble-title {
    font-size: 0.82rem; font-weight: 700; color: var(--text);
    margin-bottom: 0.3rem;
}
.chat-bubble-text { font-size: 0.85rem; color: var(--text2); line-height: 1.7; }
.chat-bubble-meta {
    font-size: 0.7rem; color: var(--text3); margin-top: 0.5rem;
    display: flex; align-items: center; gap: 6px;
}
.chat-reply {
    margin-top: 0.65rem; padding-top: 0.65rem;
    border-top: 1px dashed var(--border);
}
.chat-reply-header { font-size: 0.7rem; font-weight: 700; color: var(--green); margin-bottom: 0.3rem; }
.chat-reply-text { font-size: 0.85rem; color: var(--text2); line-height: 1.7; }

/* ── Coach message box (active) ── */
.balasan-box { background:var(--bg3); border:1px solid var(--green); border-radius:10px; padding:1rem; margin-top:0.75rem; }

/* ── Misc ── */
.badge-from-admin { display:inline-flex; align-items:center; gap:4px; font-size:0.65rem; font-weight:700; padding:3px 9px; border-radius:50px; background:rgba(124,111,224,.15); color:var(--purple2); }
.readonly-notice { display:flex; align-items:center; gap:8px; background:rgba(0,212,170,0.07); border:1px solid rgba(0,212,170,0.25); border-radius:10px; padding:0.75rem 1rem; font-size:0.8rem; color:var(--green); margin-bottom:1.25rem; }
.session-divider {
    display: flex; align-items: center; gap: 10px;
    margin: 1.5rem 0 1rem; font-size: 0.7rem; font-weight: 700;
    color: var(--text3); text-transform: uppercase; letter-spacing: 0.4px;
}
.session-divider::before, .session-divider::after {
    content: ''; flex: 1; height: 1px; background: var(--border);
}
</style>
@endpush

@section('content')
<div class="assign-wrap">
  <h2 style="font-size:1.5rem;font-weight:800;margin-bottom:0.4rem;">📝 Tugas & Sesi Coaching Saya</h2>
  <p style="color:var(--text2);font-size:0.875rem;margin-bottom:1.75rem;">Pantau sesi aktif, kirim pertanyaan, dan baca arsip feedback dari coach kamu.</p>

  {{-- Tab Navigation --}}
  <div class="sess-tabs" role="tablist">
    @if($activeSessions->count() > 0)
      <button class="sess-tab active" id="tab-active" onclick="switchTab('active')" role="tab" aria-selected="true">
        🎮 Sesi Aktif
        <span class="tab-count">{{ $activeSessions->count() }}</span>
      </button>
    @endif
    <button class="sess-tab {{ $activeSessions->count() > 0 ? '' : 'active' }}"
            id="tab-archive" onclick="switchTab('archive')" role="tab"
            aria-selected="{{ $activeSessions->count() > 0 ? 'false' : 'true' }}">
      📦 Arsip Selesai
      <span class="tab-count">{{ $archivedSessions->count() }}</span>
    </button>
  </div>

  {{-- ═══════════════════════════════════════════
       TAB 1: SESI AKTIF
  ═══════════════════════════════════════════ --}}
  @if($activeSessions->count() > 0)
  <div class="sess-panel active" id="panel-active" role="tabpanel">

    {{-- Gate: cek akses coaching user --}}
    @if(auth()->user()->has_paid)
      {{-- Form kirim tugas baru --}}
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

    @elseif(auth()->user()->hasPendingCoaching())
      {{-- Transaksi pending: menunggu konfirmasi admin --}}
      <div style="background:rgba(255,140,66,0.08);border:1px solid rgba(255,140,66,0.3);border-radius:14px;padding:1.5rem;margin-bottom:1.5rem;display:flex;gap:14px;align-items:flex-start;">
        <div style="font-size:1.8rem;flex-shrink:0;">⏳</div>
        <div>
          <div style="font-weight:700;font-size:0.95rem;margin-bottom:0.4rem;">Pembayaran Sedang Diverifikasi</div>
          <p style="color:var(--text2);font-size:0.85rem;line-height:1.7;margin-bottom:0.9rem;">
            Pembayaran coaching kamu sedang diverifikasi oleh admin. Fitur kirim tugas aktif setelah dikonfirmasi.
          </p>
          <a href="{{ route('payment.pending') }}" style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,140,66,0.15);color:var(--orange);padding:7px 14px;border-radius:8px;font-size:0.82rem;font-weight:700;">📋 Lihat Status Pembayaran</a>
        </div>
      </div>

    @else
      {{-- Belum beli sama sekali --}}
      <div style="background:var(--bg2);border:1px solid var(--border);border-radius:14px;padding:1.5rem;margin-bottom:1.5rem;display:flex;gap:14px;align-items:flex-start;">
        <div style="font-size:1.8rem;flex-shrink:0;">🔒</div>
        <div>
          <div style="font-weight:700;font-size:0.95rem;margin-bottom:0.4rem;">Akses Coaching Diperlukan</div>
          <p style="color:var(--text2);font-size:0.85rem;line-height:1.7;margin-bottom:0.9rem;">
            Untuk kirim tugas ke coach, kamu perlu membeli salah satu paket coaching terlebih dahulu.
          </p>
          <a href="{{ route('coaching') }}" style="display:inline-flex;align-items:center;gap:6px;background:var(--grad-primary);color:#fff;padding:9px 18px;border-radius:10px;font-size:0.85rem;font-weight:700;box-shadow:0 8px 20px -8px rgba(139,123,255,.6);">🎮 Lihat Paket Coaching</a>
        </div>
      </div>
    @endif

    {{-- Daftar sesi aktif --}}
    @forelse($activeSessions as $item)
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
              {{ $item->status === 'menunggu' ? '⏳ Menunggu' : '🔄 Diproses' }}
            </span>
          @else
            <span class="status-badge status-diproses">🔄 Berlangsung</span>
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
      @if(auth()->user()->has_paid)
        {{-- Sudah bayar tapi belum ada sesi aktif (bisa semuanya sudah selesai) --}}
        <div style="text-align:center;padding:2.5rem;color:var(--text3);background:var(--bg2);border:1px dashed var(--border);border-radius:14px;">
          <div style="font-size:2.5rem;margin-bottom:0.75rem;">💬</div>
          <p style="font-weight:600;margin-bottom:0.4rem;">Tidak ada sesi aktif saat ini</p>
          <p style="font-size:0.82rem;">Gunakan form di atas untuk memulai percakapan baru dengan coach.</p>
        </div>
      @else
        <div style="text-align:center;padding:2.5rem;color:var(--text3);">
          <div style="font-size:2.5rem;margin-bottom:0.75rem;">📭</div>
          <p>Belum ada sesi aktif.</p>
        </div>
      @endif
    @endforelse
  </div>
  @endif

  {{-- ═══════════════════════════════════════════
       TAB 2: ARSIP — HISTORY PERCAKAPAN
  ═══════════════════════════════════════════ --}}
  <div class="sess-panel {{ $activeSessions->count() > 0 ? '' : 'active' }}" id="panel-archive" role="tabpanel">

    @if($archivedSessions->isNotEmpty())
      <div class="readonly-notice">
        <span style="font-size:1.1rem;">📖</span>
        <span>Riwayat percakapan dengan coach — sudah <strong>read-only</strong> dan tidak bisa dibalas lagi.</span>
      </div>

      <div class="chat-timeline">
        @foreach($archivedSessions as $item)
          @if($item->from_admin)
            {{-- Pesan dari Coach/Admin --}}
            <div class="chat-msg chat-coach">
              <div class="chat-bubble">
                <div class="chat-bubble-header coach-header">📨 Coach / Admin</div>
                <div class="chat-bubble-text">{{ $item->tugas_teks }}</div>
                <div class="chat-bubble-meta">
                  <span>{{ $item->created_at->format('d M Y, H:i') }}</span>
                  <span>·</span>
                  <span>{{ $item->created_at->diffForHumans() }}</span>
                  <span class="status-badge status-selesai">✅ Selesai</span>
                </div>
              </div>
            </div>
          @else
            {{-- Pesan dari User + feedback coach --}}
            <div class="chat-msg chat-user">
              <div class="chat-bubble">
                <div class="chat-bubble-header user-header">🧑 Kamu</div>
                <div class="chat-bubble-title">{{ $item->judul }}</div>
                <div class="chat-bubble-text">{{ $item->tugas_teks }}</div>
                <div class="chat-bubble-meta">
                  <span>{{ $item->created_at->format('d M Y, H:i') }}</span>
                  <span>·</span>
                  <span>{{ $item->created_at->diffForHumans() }}</span>
                </div>
                @if($item->balasan_admin)
                  <div class="chat-reply">
                    <div class="chat-reply-header">💬 Feedback Coach</div>
                    <div class="chat-reply-text">{{ $item->balasan_admin }}</div>
                  </div>
                @endif
              </div>
            </div>
          @endif
        @endforeach
      </div>

      <div style="margin-top:1.5rem;padding:1rem;border:1px dashed var(--border);border-radius:10px;text-align:center;font-size:0.8rem;color:var(--text3);display:flex;align-items:center;justify-content:center;gap:6px;">
        🔒 Akhir riwayat — semua sesi sudah selesai.
      </div>
    @else
      <div style="text-align:center;padding:3rem;color:var(--text3);">
        <div style="font-size:3rem;margin-bottom:1rem;">📦</div>
        <p style="font-weight:600;margin-bottom:0.4rem;">Belum ada sesi yang selesai</p>
        <p style="font-size:0.82rem;">Riwayat percakapan dengan coach akan muncul di sini setelah sesi ditutup oleh admin.</p>
      </div>
    @endif
  </div>

</div>
@endsection

@push('scripts')
<script>
  function switchTab(tab) {
    // Update tombol tab (skip jika tab tidak ada di DOM)
    document.querySelectorAll('.sess-tab').forEach(function(btn) {
      btn.classList.remove('active');
      btn.setAttribute('aria-selected', 'false');
    });
    var tabBtn = document.getElementById('tab-' + tab);
    if (tabBtn) {
      tabBtn.classList.add('active');
      tabBtn.setAttribute('aria-selected', 'true');
    }

    // Update panel
    document.querySelectorAll('.sess-panel').forEach(function(p) {
      p.classList.remove('active');
    });
    document.getElementById('panel-' + tab).classList.add('active');
  }

  // Jika ada flash success, scrollkan ke atas agar terlihat
  document.addEventListener('DOMContentLoaded', function() {
    var successAlert = document.querySelector('.alert-success');
    if (successAlert) {
      successAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
  });
</script>
@endpush
