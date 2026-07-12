@extends('layouts.app')
@section('title', 'Admin — Sesi Coaching')

@push('styles')
<style>
.cw { max-width: 1000px; margin: 0 auto; padding: 2.5rem 2rem; }

.admin-tabs { display: flex; gap: 8px; margin-bottom: 28px; flex-wrap: wrap; }
.admin-tab { padding: 9px 20px; border-radius: 9px; border: 1px solid var(--border); background: var(--bg2); color: var(--text2); font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all .2s; text-decoration: none; display: inline-flex; align-items: center; gap: 7px; }
.admin-tab:hover, .admin-tab.active { background: var(--grad-primary); border-color: transparent; color: #fff; }
.admin-tab-badge { background: rgba(255,255,255,0.2); color: #fff; font-size: 0.68rem; padding: 1px 7px; border-radius: 50px; font-weight: 700; }

.section-divider { display: flex; align-items: center; gap: 10px; margin: 1.5rem 0 1rem; font-size: 0.75rem; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: 0.4px; }
.section-divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }

.session-card { background: var(--bg2); border: 1px solid var(--border); border-radius: 14px; padding: 1.5rem; margin-bottom: 1rem; }
.session-card.finished { opacity: 0.7; }
.session-head { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
.user-info { display: flex; align-items: center; gap: 10px; }
.user-avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--purple), var(--cyan)); display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 700; color: #fff; flex-shrink: 0; }
.session-meta { font-size: 0.75rem; color: var(--text3); margin-top: 2px; }
.session-body { color: var(--text2); font-size: 0.875rem; line-height: 1.7; }

.chat-box { background: var(--bg3); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; margin-top: 12px; }
.chat-header-bar { background: var(--bg2); padding: 10px 14px; border-bottom: 1px solid var(--border); font-size: 12px; font-weight: 700; color: var(--text2); display: flex; justify-content: space-between; align-items: center; }
.chat-msgs { max-height: 280px; overflow-y: auto; padding: 12px; }
.chat-msg-row { margin-bottom: 8px; display: flex; }
.chat-msg-row.admin { justify-content: flex-end; }
.chat-bubble { max-width: 80%; padding: 8px 12px; border-radius: 12px; font-size: 13px; line-height: 1.4; }
.chat-msg-row.admin .chat-bubble { background: var(--purple-btn); color: #fff; }
.chat-msg-row:not(.admin) .chat-bubble { background: var(--bg2); color: var(--text); border: 1px solid var(--border); }
.chat-time { font-size: 9px; color: var(--text3); margin-bottom: 2px; }

.chat-input-row { display: flex; gap: 8px; padding: 10px; border-top: 1px solid var(--border); background: var(--bg2); }
.chat-input-row input { flex: 1; background: var(--bg); border: 1px solid var(--border); border-radius: 8px; padding: 10px 12px; color: var(--text); font-size: 13px; outline: none; font-family: inherit; }
.chat-input-row button { background: var(--grad-primary); border: none; border-radius: 8px; padding: 10px 16px; color: #fff; font-weight: 700; cursor: pointer; font-family: inherit; font-size: 12px; }

.finished-notice { text-align: center; padding: 16px; background: rgba(43,230,186,0.06); border: 1px solid rgba(43,230,186,0.2); border-radius: 10px; color: var(--green); font-size: 13px; font-weight: 600; margin-top: 12px; }

.empty-state { text-align: center; padding: 3rem; color: var(--text3); background: var(--bg2); border: 1px dashed var(--border); border-radius: 14px; }
</style>
@endpush

@section('content')
<div class="cw">

  @if(session('success'))
    <div style="background:rgba(43,230,186,0.1);border:1px solid rgba(43,230,186,0.3);border-radius:10px;padding:0.9rem 1.25rem;margin-bottom:1.25rem;font-size:0.875rem;color:var(--green);">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div style="background:rgba(255,114,114,0.1);border:1px solid rgba(255,114,114,0.3);border-radius:10px;padding:0.9rem 1.25rem;margin-bottom:1.25rem;font-size:0.875rem;color:var(--red);">{{ session('error') }}</div>
  @endif

  <div class="admin-tabs">
    <a href="{{ route('admin.dashboard') }}" class="admin-tab"><x-cs-icon name="bar-chart" size="14" stroke="2" /> Dashboard</a>
    <a href="{{ route('admin.users') }}" class="admin-tab"><x-cs-icon name="users" size="14" stroke="2" /> User</a>
    <a href="{{ route('admin.assignments') }}" class="admin-tab active"><x-cs-icon name="zap" size="14" stroke="2" /> Sesi Coaching
      @if($coachingCount > 0)<span class="admin-tab-badge">{{ $coachingCount }}</span>@endif
    </a>
    <a href="{{ route('admin.courses') }}" class="admin-tab"><x-cs-icon name="book-open" size="14" stroke="2" /> Kelola Course</a>
  </div>

  <h2 style="font-size:1.4rem;font-weight:800;margin-bottom:0.3rem;">🎮 Sesi Coaching</h2>
  <p style="color:var(--text2);font-size:0.875rem;margin-bottom:1.75rem;">Chat langsung dengan user via sesi coaching yang aktif.</p>

  {{-- SESI AKTIF --}}
  @if($coachingSessionsActive->isNotEmpty())
    <div class="section-divider">🎮 Aktif ({{ $coachingSessionsActive->count() }})</div>
    @foreach($coachingSessionsActive as $sesi)
      <div class="session-card" id="session-{{ $sesi->id }}" data-id="{{ $sesi->id }}">
        <div class="session-head">
          <div class="user-info">
            <div class="user-avatar">{{ strtoupper(mb_substr($sesi->user->name, 0, 1)) }}</div>
            <div>
              <div style="font-weight:700;font-size:0.95rem;color:var(--text);">{{ $sesi->user->name }}</div>
              <div class="session-meta">{{ $sesi->judul }} · {{ $sesi->created_at->diffForHumans() }}</div>
            </div>
          </div>
        </div>

        <div class="chat-box">
          <div class="chat-header-bar">
            <span>💬 Percakapan</span>
            <button onclick="completeSessionInline({{ $sesi->id }})" style="background:var(--green);border:none;border-radius:6px;padding:5px 12px;color:#000;font-weight:700;cursor:pointer;font-size:11px;font-family:inherit;">✓ Selesaikan</button>
          </div>
          <div class="chat-msgs" id="msgs-{{ $sesi->id }}">Memuat...</div>
          <div class="chat-input-row">
            <input type="text" id="input-{{ $sesi->id }}" placeholder="Tulis balasan..." onkeydown="if(event.key==='Enter')sendInlineReply({{ $sesi->id }})">
            <button onclick="sendInlineReply({{ $sesi->id }})">Kirim</button>
          </div>
        </div>
        <div class="finished-notice" id="closed-{{ $sesi->id }}" style="display:none;">✅ Sesi ini sudah selesai — read only</div>
      </div>
    @endforeach
  @endif

  {{-- ARSIP (dropdown accordion) --}}
  @if($coachingSessionsFinished->isNotEmpty())
    <div class="section-divider" style="margin-top:2rem;">📦 Arsip ({{ $coachingSessionsFinished->count() }})</div>
    @foreach($coachingSessionsFinished as $sesi)
      <div class="session-card finished" data-id="{{ $sesi->id }}" style="overflow:hidden;">
        <div class="session-head" onclick="this.nextElementSibling.classList.toggle('open'); this.querySelector('.arr').classList.toggle('open');" style="cursor:pointer;">
          <div class="user-info" style="flex:1;">
            <div class="user-avatar">{{ strtoupper(mb_substr($sesi->user->name, 0, 1)) }}</div>
            <div>
              <div style="font-weight:700;font-size:0.95rem;color:var(--text);">{{ $sesi->user->name }}</div>
              <div class="session-meta">{{ $sesi->judul }} · Selesai {{ $sesi->completed_at?->diffForHumans() ?? $sesi->updated_at->diffForHumans() }}</div>
            </div>
          </div>
          <span class="arr" style="color:var(--text3);font-size:12px;transition:transform .2s;">▾</span>
        </div>
        <div class="archive-drop" style="display:none;padding-top:12px;">
          <div class="chat-box">
            <div class="chat-header-bar">💬 Riwayat Percakapan (read-only)</div>
            <div class="chat-msgs" id="msgs-{{ $sesi->id }}">Memuat...</div>
          </div>
        </div>
      </div>
    @endforeach
    <style>.archive-drop.open{display:block!important;} .arr.open{transform:rotate(180deg);}</style>
  @endif

  @if($coachingSessionsActive->isEmpty() && $coachingSessionsFinished->isEmpty())
    <div class="empty-state">
      <div style="font-size:2rem;margin-bottom:0.5rem;">💬</div>
      <p style="font-weight:600;">Belum ada sesi coaching</p>
      <p style="font-size:0.82rem;">Sesi akan muncul setelah admin approve transaksi coaching user.</p>
    </div>
  @endif

</div>
@endsection

@push('scripts')
<script>
function escHtml(s) { return String(s).replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

function loadChat(id) {
  fetch('/admin/coaching-inbox/' + id + '/messages')
    .then(function(r) { return r.json(); })
    .then(function(d) {
      var c = document.getElementById('msgs-' + id);
      if (!c) return;
      c.innerHTML = (d.messages||[]).map(function(m) {
        var side = m.is_admin ? 'admin' : '';
        return '<div class="chat-msg-row ' + side + '"><div class="chat-bubble"><div class="chat-time">' + escHtml(m.sender) + ' · ' + m.time + '</div>' + escHtml(m.message) + '</div></div>';
      }).join('') || '<div style="text-align:center;color:var(--text3);padding:10px;font-size:12px;">Belum ada pesan</div>';
      c.scrollTop = c.scrollHeight;
      // Handle closed
      if (d.is_closed) {
        var inp = document.getElementById('input-' + id); if (inp) inp.parentElement.style.display = 'none';
        var cls = document.getElementById('closed-' + id); if (cls) cls.style.display = 'block';
      }
    });
}

function sendInlineReply(id) {
  var input = document.getElementById('input-' + id);
  var msg = input.value.trim();
  if (!msg) return;
  input.value = '';
  var token = document.querySelector('meta[name="csrf-token"]');
  fetch('/admin/coaching-inbox/' + id + '/reply', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token.getAttribute('content'), 'Accept': 'application/json' },
    body: JSON.stringify({ message: msg })
  }).then(function(r) { return r.json(); }).then(function(d) { if (d.success) loadChat(id); });
}

function completeSessionInline(id) {
  if (!confirm('Selesaikan sesi ini? User akan bisa beli paket coaching baru.')) return;
  var token = document.querySelector('meta[name="csrf-token"]');
  fetch('/admin/coaching-inbox/' + id + '/complete', {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': token.getAttribute('content'), 'Accept': 'application/json' }
  }).then(function(r) { return r.json(); }).then(function(d) {
    if (d.success) location.reload();
  });
}

// Init semua chat
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('[data-id]').forEach(function(el) {
    loadChat(el.dataset.id);
    if (!el.classList.contains('finished')) {
      setInterval(function() { loadChat(el.dataset.id); }, 4000);
    }
  });
});
</script>
@endpush
