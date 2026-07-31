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
  <h2 style="font-size:1.5rem;font-weight:800;margin-bottom:0.4rem;display:flex;align-items:center;gap:8px;">
    <x-cs-icon name="file-edit" size="22" stroke="2" /> Tugas & Sesi Coaching Saya
  </h2>
  <p style="color:var(--text2);font-size:0.875rem;margin-bottom:1.75rem;">Pantau sesi aktif, kirim pertanyaan, dan baca arsip feedback dari coach kamu.</p>

  {{-- Tab Navigation --}}
  <div class="sess-tabs" role="tablist">
    @if($activeSessions->count() > 0)
      <button class="sess-tab active" id="tab-active" onclick="switchSessTab('active')" role="tab" aria-selected="true">
        <x-cs-icon name="zap" size="14" stroke="2" /> Sesi Aktif
        <span class="tab-count">{{ $activeSessions->count() }}</span>
      </button>
    @endif
    <button class="sess-tab {{ $activeSessions->count() > 0 ? '' : 'active' }}"
            id="tab-archive" onclick="switchSessTab('archive')" role="tab"
            aria-selected="{{ $activeSessions->count() > 0 ? 'false' : 'true' }}">
      <x-cs-icon name="inbox" size="14" stroke="2" /> Arsip Selesai
      <span class="tab-count">{{ $archivedSessions->count() }}</span>
    </button>
  </div>

  {{-- ═══════════════════════════════════════════
       TAB 1: SESI AKTIF
  ═══════════════════════════════════════════ --}}
  @if($activeSessions->count() > 0)
  <div class="sess-panel active" id="panel-active" role="tabpanel">

    {{-- Daftar sesi aktif dengan chat UI --}}
    @forelse($activeSessions as $item)
      <div class="assign-card {{ $item->from_admin ? 'from-admin-card' : '' }}" id="session-{{ $item->id }}" data-session-id="{{ $item->id }}">
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
          <span class="status-badge status-{{ $item->status }}" id="status-badge-{{ $item->id }}">
            {{ $item->status === 'menunggu' ? '⏳ Menunggu' : ($item->status === 'diproses' ? '🔄 Berlangsung' : '✅ Selesai') }}
          </span>
        </div>

        {{-- Chat messages container --}}
        <div id="chat-msgs-{{ $item->id }}" style="max-height:300px;overflow-y:auto;margin-bottom:10px;background:var(--bg);border-radius:10px;padding:12px;">
          <div style="text-align:center;color:var(--text3);font-size:12px;">Memuat percakapan...</div>
        </div>

        {{-- Input area --}}
        <div id="chat-input-{{ $item->id }}" style="display:flex;gap:8px;">
          <input type="text" id="input-{{ $item->id }}" placeholder="Tulis balasan..."
            style="flex:1;background:var(--bg3);border:1px solid var(--border);border-radius:8px;
            padding:10px 12px;color:var(--text);font-size:13px;outline:none;font-family:inherit;"
            onkeydown="if(event.key==='Enter')sendUserReply({{ $item->id }})">
          <button onclick="sendUserReply({{ $item->id }})"
            style="background:var(--grad-primary);border:none;border-radius:8px;padding:10px 14px;
            color:#fff;font-weight:700;cursor:pointer;font-size:12px;font-family:inherit;">Kirim</button>
        </div>

        {{-- Closed notice --}}
        <div id="chat-closed-{{ $item->id }}" style="display:none;text-align:center;padding:12px;background:rgba(0,212,170,0.08);border:1px solid rgba(0,212,170,0.25);border-radius:10px;margin-top:8px;">
          <div style="color:var(--green);font-weight:700;font-size:13px;margin-bottom:6px;">✅ Sesi ini sudah selesai</div>
          <a href="{{ route('coaching') }}" style="display:inline-block;background:var(--grad-primary);color:#fff;padding:8px 16px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;">+ Pilih Paket Coaching Baru</a>
        </div>
      </div>
    @empty
      @if(auth()->user()->has_paid)
        <div style="text-align:center;padding:2.5rem;color:var(--text3);background:var(--bg2);border:1px dashed var(--border);border-radius:14px;">
          <div style="font-size:2.5rem;margin-bottom:0.75rem;">💬</div>
          <p style="font-weight:600;margin-bottom:0.4rem;">Tidak ada sesi aktif saat ini</p>
          <p style="font-size:0.82rem;">Pilih paket coaching untuk memulai sesi dengan coach.</p>
        </div>
      @else
        <div style="text-align:center;padding:3rem 1.5rem;color:var(--text3);">
          <div style="display:inline-flex;align-items:center;justify-content:center;width:56px;height:56px;border-radius:50%;background:rgba(139,123,255,0.12);border:1px solid rgba(139,123,255,0.25);margin-bottom:1rem;color:var(--purple2);">
            <x-cs-icon name="message-square" size="24" stroke="1.75" />
          </div>
          <p style="font-weight:700;font-size:0.95rem;color:var(--text);margin-bottom:0.4rem;">Belum ada sesi coaching aktif</p>
          <p style="font-size:0.82rem;">Sesi akan otomatis muncul di sini setelah admin menyetujui transaksi coaching kamu.</p>
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
        <span>Riwayat percakapan dengan coach — sudah <strong>hanya bisa dibaca</strong> dan tidak bisa dibalas lagi.</span>
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
function switchSessTab(tab) {
  document.querySelectorAll('.sess-tab').forEach(function(btn) {
    btn.classList.remove('active');
    btn.setAttribute('aria-selected', 'false');
  });
  var tabBtn = document.getElementById('tab-' + tab);
  if (tabBtn) {
    tabBtn.classList.add('active');
    tabBtn.setAttribute('aria-selected', 'true');
  }
  document.querySelectorAll('.sess-panel').forEach(function(p) {
    p.classList.remove('active');
  });
  var panel = document.getElementById('panel-' + tab);
  if (panel) panel.classList.add('active');
}

// ── User Chat ──
function escHtml(s) { return String(s).replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

function loadUserMessages(sessionId) {
  fetch('/assignments/' + sessionId + '/messages')
    .then(function(r) { return r.json(); })
    .then(function(data) {
      var container = document.getElementById('chat-msgs-' + sessionId);
      if (!container) return;
      var msgs = data.messages || [];
      container.innerHTML = msgs.map(function(m) {
        var align = m.is_admin ? 'flex-start' : 'flex-end';
        var bg = m.is_admin ? 'var(--bg3)' : 'var(--purple-btn)';
        var color = m.is_admin ? 'var(--text)' : '#fff';
        return '<div style="display:flex;justify-content:' + align + ';margin-bottom:8px;">' +
          '<div style="max-width:85%;">' +
          '<div style="font-size:10px;color:var(--text3);margin-bottom:2px;">' + escHtml(m.sender) + ' · ' + m.time + '</div>' +
          '<div style="background:' + bg + ';color:' + color + ';padding:8px 12px;border-radius:12px;font-size:13px;line-height:1.4;">' + escHtml(m.message) + '</div>' +
          '</div></div>';
      }).join('');
      container.scrollTop = container.scrollHeight;

      // Handle closed state
      var inputArea = document.getElementById('chat-input-' + sessionId);
      var closedNotice = document.getElementById('chat-closed-' + sessionId);
      var badge = document.getElementById('status-badge-' + sessionId);
      if (data.is_closed) {
        if (inputArea) inputArea.style.display = 'none';
        if (closedNotice) closedNotice.style.display = 'block';
        if (badge) { badge.className = 'status-badge status-selesai'; badge.textContent = '✅ Selesai'; }
      }
    });
}

function sendUserReply(sessionId) {
  var input = document.getElementById('input-' + sessionId);
  var msg = input.value.trim();
  if (!msg) return;
  input.value = '';
  var token = document.querySelector('meta[name="csrf-token"]');
  fetch('/assignments/' + sessionId + '/reply', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token.getAttribute('content'), 'Accept': 'application/json' },
    body: JSON.stringify({ message: msg })
  }).then(function(r) { return r.json(); })
    .then(function(data) {
      if (data.success) loadUserMessages(sessionId);
    });
}

// Init chat untuk semua sesi aktif
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('[data-session-id]').forEach(function(el) {
    var id = el.dataset.sessionId;
    loadUserMessages(id);
    setInterval(function() { loadUserMessages(id); }, 4000);
  });
});

// Auto-refresh polling setiap 30 detik untuk cek update tugas baru
let lastActiveCount = {{ $activeSessions->count() }};
setInterval(function() {
  fetch('{{ route("assignments.check") }}')
    .then(res => res.json())
    .then(data => {
      if (data.active_count !== lastActiveCount || data.has_unread) {
        // Ada perubahan jumlah tugas aktif atau ada pesan belum dibaca, reload halaman
        window.location.reload();
      }
    })
    .catch(err => console.error('Polling error:', err));
}, 30000); // 30 detik
</script>
@endpush
