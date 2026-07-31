@extends('layouts.app')
@section('title', 'Admin — Dashboard')

@push('styles')
    <link rel="stylesheet" href="/css/admin.css" />
    <style>
        .pending-table { width:100%; border-collapse:collapse; font-size:0.85rem; }
        .pending-table th { text-align:left; padding:8px 12px; font-size:0.7rem; font-weight:700; color:var(--text2); text-transform:uppercase; letter-spacing:0.5px; border-bottom:1px solid var(--border); }
        .pending-table td { padding:11px 12px; border-bottom:1px solid var(--border); vertical-align:middle; }
        .pending-table tr:last-child td { border-bottom:none; }
        .pending-table tr:hover td { background:rgba(124,111,224,0.04); }
        .approve-btn { display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:8px; font-size:0.78rem; font-weight:700; border:none; cursor:pointer; transition:all .2s; }
        .approve-btn--green { background:rgba(0,212,170,0.15); color:var(--green); }
        .approve-btn--green:hover { background:rgba(0,212,170,0.28); }
        .approve-btn--red { background:rgba(255,80,80,0.12); color:#ff5f5f; }
        .approve-btn--red:hover { background:rgba(255,80,80,0.22); }
        .approve-btn--purple { background:rgba(124,111,224,0.12); color:var(--purple2); }
        .approve-btn--purple:hover { background:rgba(124,111,224,0.22); }
        .notif-feed { display:flex; flex-direction:column; gap:0; }
        .notif-item { display:flex; align-items:flex-start; gap:10px; padding:10px 0; border-bottom:1px solid var(--border); }
        .notif-item:last-child { border-bottom:none; }
        .notif-dot { width:8px; height:8px; border-radius:50%; margin-top:5px; flex-shrink:0; }
        .notif-dot--pending  { background:var(--orange); box-shadow:0 0 6px rgba(255,140,66,.5); }
        .notif-dot--approved { background:var(--green); }
        .notif-dot--rejected { background:#ff5f5f; }
        
        /* Bukti Modal — unique prefix to avoid layout JS conflicts */
        .bm-overlay { display:none; position:fixed; inset:0; background:rgba(5,7,15,0.82); z-index:10000; align-items:center; justify-content:center; backdrop-filter:blur(8px); -webkit-backdrop-filter:blur(8px); }
        .bm-overlay.bm-open { display:flex; }
        .bm-box { background:var(--bg2); border:1px solid var(--border); border-radius:20px; width:min(720px,95vw); max-height:92vh; overflow:hidden; display:flex; flex-direction:column; box-shadow:0 32px 80px rgba(0,0,0,0.65),0 0 0 1px rgba(255,255,255,0.05); }
        .bm-head { padding:1.1rem 1.4rem; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; flex-shrink:0; background:linear-gradient(135deg,var(--bg3),var(--bg4)); }
        .bm-head h3 { font-size:1rem; font-weight:800; margin:0; display:flex; align-items:center; gap:8px; }
        .bm-close { width:32px; height:32px; border-radius:9px; background:rgba(255,255,255,0.06); border:1px solid var(--border); color:var(--text2); font-size:1rem; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all .2s; }
        .bm-close:hover { background:rgba(255,80,80,0.15); color:#ff5f5f; border-color:rgba(255,80,80,0.3); }
        .bm-body { display:flex; overflow:hidden; flex:1; min-height:0; }
        .bm-sidebar { width:220px; flex-shrink:0; padding:1.25rem; border-right:1px solid var(--border); overflow-y:auto; background:rgba(0,0,0,0.15); }
        .bm-main { flex:1; overflow-y:auto; padding:1.25rem; }
        .bm-field { margin-bottom:1rem; }
        .bm-label { font-size:0.65rem; font-weight:700; color:var(--text3); text-transform:uppercase; letter-spacing:0.6px; margin-bottom:3px; }
        .bm-value { font-size:0.88rem; font-weight:600; color:var(--text); }
        .bm-img-wrap { position:relative; border-radius:12px; overflow:hidden; border:1px solid var(--border); background:var(--bg3); }
        .bm-img-wrap img { display:block; width:100%; height:auto; }
        .bm-no-bukti { background:rgba(255,140,66,0.08); border:1px dashed rgba(255,140,66,0.4); border-radius:12px; padding:2rem; text-align:center; }
        @media(max-width:560px){.bm-body{flex-direction:column;}.bm-sidebar{width:100%;border-right:none;border-bottom:1px solid var(--border);}}

        @keyframes rowHighlight {
          0%   { background:rgba(255,140,66,0.22); }
          100% { background:transparent; }
        }
        .pending-row-new { animation: rowHighlight 2.5s ease-out; }
        .live-dot { width:8px;height:8px;border-radius:50%;background:var(--green);display:inline-block;margin-right:6px;box-shadow:0 0 0 0 rgba(0,212,170,.6);animation:livePulse 1.5s infinite; }
        @keyframes livePulse { 0%{box-shadow:0 0 0 0 rgba(0,212,170,.6)}70%{box-shadow:0 0 0 6px rgba(0,212,170,0)}100%{box-shadow:0 0 0 0 rgba(0,212,170,0)} }
        .rt-toast{position:fixed;top:1rem;right:1rem;z-index:99999;background:var(--bg2);border:1px solid rgba(255,140,66,0.5);border-radius:12px;padding:0.85rem 1.1rem;display:flex;align-items:center;gap:10px;font-size:0.85rem;font-weight:600;box-shadow:0 8px 24px rgba(0,0,0,.4);transform:translateX(120%);transition:transform .35s cubic-bezier(.34,1.56,.64,1);}
        .rt-toast.show{transform:translateX(0);}
    </style>
@endpush

@section('content')
<div class="admin-wrap">
  <div class="admin-header">
    <h2>Admin Dashboard</h2>
    <p>Ringkasan aktivitas platform CS2 Academy</p>
  </div>

  <div class="admin-tabs">
    <a href="{{ route('admin.dashboard') }}" class="admin-tab active">
      <x-cs-icon name="bar-chart" size="14" stroke="2" /> Dashboard
    </a>
    <a href="{{ route('admin.users') }}" class="admin-tab">
      <x-cs-icon name="users" size="14" stroke="2" /> User
    </a>
    <a href="{{ route('admin.assignments') }}" class="admin-tab">
      <x-cs-icon name="zap" size="14" stroke="2" /> Sesi Coaching
    </a>
    <a href="{{ route('admin.courses') }}" class="admin-tab">
      <x-cs-icon name="book-open" size="14" stroke="2" /> Kelola Course
    </a>
  </div>

  @if(session('success'))
    <div style="background:rgba(0,212,170,0.12);border:1px solid rgba(0,212,170,0.3);border-radius:10px;padding:0.9rem 1.25rem;margin-bottom:1.25rem;font-size:0.875rem;color:var(--green);">{{ session('success') }}</div>
  @endif

  {{-- Stat Cards --}}
  <div class="stat-grid">
    <div class="stat-card">
      <div class="stat-ic stat-ic--purple"><x-cs-icon name="users" size="20" stroke="1.75" /></div>
      <div class="stat-val">{{ $stats['total_users'] }}</div>
      <div class="stat-label">Total Pemain</div>
    </div>
    <div class="stat-card">
      <div class="stat-ic stat-ic--green"><x-cs-icon name="credit-card" size="20" stroke="1.75" /></div>
      <div class="stat-val">{{ $stats['total_paid'] }}</div>
      <div class="stat-label">Sudah Bayar</div>
    </div>
    <div class="stat-card">
      <div class="stat-ic stat-ic--orange"><x-cs-icon name="clock" size="20" stroke="1.75" /></div>
      <div class="stat-val">{{ $stats['total_pending_payments'] }}</div>
      <div class="stat-label">Menunggu Bayar</div>
    </div>
    <div class="stat-card">
      <div class="stat-ic stat-ic--blue"><x-cs-icon name="book-open" size="20" stroke="1.75" /></div>
      <div class="stat-val">{{ $stats['total_courses'] }}</div>
      <div class="stat-label">Total Kursus</div>
    </div>
    <div class="stat-card">
      <div class="stat-ic stat-ic--pink"><x-cs-icon name="repeat" size="20" stroke="1.75" /></div>
      <div class="stat-val">{{ $stats['total_transactions'] }}</div>
      <div class="stat-label">Total Transaksi</div>
    </div>
  </div>

  {{-- Pending Payments (live-updatable) --}}
  <div id="pendingSection" style="margin-bottom:1.5rem;{{ $pendingTransactions->isEmpty() ? 'display:none;' : '' }}">
    <div class="dash-card" style="border:1px solid rgba(255,140,66,0.35);background:rgba(255,140,66,0.04);">
      <h3 style="display:flex;align-items:center;gap:8px;">
        <x-cs-icon name="credit-card" size="16" stroke="2" />
        <span>Pembayaran Menunggu Verifikasi</span>
        <span id="pendingBadge" style="background:var(--orange);color:#fff;font-size:0.65rem;font-weight:700;padding:2px 8px;border-radius:50px;margin-left:4px;">{{ $pendingTransactions->count() }}</span>
        <span style="margin-left:auto;font-size:0.65rem;font-weight:600;color:var(--text3);display:flex;align-items:center;"><span class="live-dot"></span>Live</span>
      </h3>
      <div style="overflow-x:auto;">
        <table class="pending-table">
          <thead>
            <tr><th>User</th><th>Paket</th><th>Harga</th><th>Waktu</th><th>Bukti</th><th style="text-align:right;">Aksi</th></tr>
          </thead>
          <tbody id="pendingTbody">
            @foreach($pendingTransactions as $trx)
              <tr id="ptr-{{ $trx->id }}">
                <td>
                  <div style="font-weight:700;font-size:0.88rem;">{{ $trx->user->name }}</div>
                  <div style="font-size:0.75rem;color:var(--text2);">{{ $trx->user->email }}</div>
                </td>
                <td style="font-weight:600;">{{ $trx->package_name }}</td>
                <td style="font-weight:700;color:var(--purple2);">{{ $trx->package_price }}</td>
                <td style="color:var(--text2);">{{ $trx->created_at->diffForHumans() }}</td>
                <td>
                  @if($trx->bukti_transfer)
                    <span style="background:rgba(0,212,170,0.15);color:var(--green);padding:2px 8px;border-radius:50px;font-size:0.7rem;font-weight:700;">Ada</span>
                  @else
                    <span style="background:rgba(255,140,66,0.15);color:var(--orange);padding:2px 8px;border-radius:50px;font-size:0.7rem;font-weight:700;">Belum</span>
                  @endif
                </td>
                <td style="text-align:right;">
                  <div style="display:flex;gap:6px;justify-content:flex-end;flex-wrap:wrap;">
                    <button type="button" class="approve-btn approve-btn--purple" onclick="bmOpen({{ $trx->id }})">Detail</button>
                    <form method="POST" action="{{ route('admin.coaching.approve', $trx) }}" style="display:inline;">@csrf<button type="submit" class="approve-btn approve-btn--green">Setujui</button></form>
                    <form method="POST" action="{{ route('admin.coaching.reject', $trx) }}" style="display:inline;">@csrf<button type="submit" class="approve-btn approve-btn--red">Batalkan</button></form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Aktivitas Coaching --}}
  <div class="dash-card">
    <h3><x-cs-icon name="credit-card" size="16" stroke="2" /> Aktivitas Pembelian Coaching</h3>
    @forelse($recentCoachingActivity as $activity)
      <div class="notif-item">
        <div class="notif-dot notif-dot--{{ $activity->status }}"></div>
        <div style="flex:1;min-width:0;">
          <div style="font-size:0.875rem;font-weight:600;line-height:1.4;">
            <strong>{{ $activity->user->name }}</strong> · {{ $activity->package_name }}
          </div>
          <div style="display:flex;align-items:center;gap:8px;margin-top:4px;">
            <span style="font-size:0.75rem;color:var(--text3);">{{ $activity->created_at->diffForHumans() }}</span>
            @if($activity->status === 'pending')
              <span style="background:rgba(255,140,66,0.2);color:var(--orange);padding:1px 8px;border-radius:50px;font-size:0.65rem;font-weight:700;">Pending</span>
            @elseif($activity->status === 'approved')
              <span style="background:rgba(0,212,170,0.15);color:var(--green);padding:1px 8px;border-radius:50px;font-size:0.65rem;font-weight:700;">Disetujui</span>
            @else
              <span style="background:rgba(255,80,80,0.12);color:#ff5f5f;padding:1px 8px;border-radius:50px;font-size:0.65rem;font-weight:700;">Ditolak</span>
            @endif
          </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;flex-shrink:0;">
          <div style="font-size:0.82rem;font-weight:700;color:var(--purple2);white-space:nowrap;">{{ $activity->package_price }}</div>
          <button type="button"
            onclick="bmOpen({{ $activity->id }})"
            style="padding:4px 10px;border-radius:7px;font-size:0.7rem;font-weight:700;border:1px solid rgba(124,111,224,0.3);background:rgba(124,111,224,0.1);color:var(--purple2);cursor:pointer;transition:all .2s;white-space:nowrap;"
            onmouseover="this.style.background='rgba(124,111,224,0.22)'"
            onmouseout="this.style.background='rgba(124,111,224,0.1)'">
            Detail
          </button>
        </div>
      </div>
    @empty
      <div class="empty-mini">Belum ada aktivitas pembelian coaching.</div>
    @endforelse
  </div>
</div>

{{-- Bukti Modal --}}
<div class="bm-overlay" id="bmDetailModal">
  <div class="bm-box">
    <div class="bm-head">
      <h3>Detail Transaksi</h3>
      <button class="bm-close" onclick="bmClose()" title="Tutup">✕</button>
    </div>
    <div class="bm-body">
      <div class="bm-sidebar" id="bmSidebar">
        <div style="text-align:center;padding:2rem 0;color:var(--text3);font-size:0.8rem;">Loading...</div>
      </div>
      <div class="bm-main" id="bmMain">
        <div style="text-align:center;padding:2rem 0;color:var(--text3);font-size:0.8rem;">Memuat data...</div>
      </div>
    </div>
  </div>
</div>

<script>
function bmOpen(transactionId) {
  const overlay = document.getElementById('bmDetailModal');
  const sidebar = document.getElementById('bmSidebar');
  const main    = document.getElementById('bmMain');

  overlay.classList.add('bm-open');
  document.body.style.overflow = 'hidden';
  sidebar.innerHTML = '<div style="text-align:center;padding:2rem 0;color:var(--text3);">⏳ Loading...</div>';
  main.innerHTML    = '<div style="text-align:center;padding:2rem 0;color:var(--text3);">⏳ Loading...</div>';

  fetch(`/admin/coaching/${transactionId}/detail`)
    .then(res => {
      if (!res.ok) throw new Error('HTTP ' + res.status);
      return res.json();
    })
    .then(data => {
      const statusColor = data.status === 'pending' ? 'var(--orange)' : (data.status === 'approved' ? 'var(--green)' : '#ff5f5f');
      const statusText  = data.status === 'pending' ? 'Pending' : (data.status === 'approved' ? 'Disetujui' : 'Ditolak');

      sidebar.innerHTML = `
        <div class="bm-field">
          <div class="bm-label">User</div>
          <div class="bm-value">${data.user_name}</div>
        </div>
        <div class="bm-field">
          <div class="bm-label">Email</div>
          <div class="bm-value" style="font-size:0.78rem;word-break:break-all;">${data.user_email}</div>
        </div>
        <div class="bm-field">
          <div class="bm-label">Paket</div>
          <div class="bm-value">${data.package_name}</div>
        </div>
        <div class="bm-field">
          <div class="bm-label">Harga</div>
          <div class="bm-value" style="color:var(--purple2);">${data.package_price}</div>
        </div>
        <div class="bm-field">
          <div class="bm-label">Status</div>
          <div class="bm-value" style="color:${statusColor};">${statusText}</div>
        </div>
        <div class="bm-field">
          <div class="bm-label">VA Code</div>
          <div class="bm-value" style="font-family:monospace;font-size:0.78rem;word-break:break-all;">${data.va_code ?? '—'}</div>
        </div>
        <div class="bm-field">
          <div class="bm-label">Order</div>
          <div class="bm-value" style="font-size:0.78rem;">${data.created_at}</div>
        </div>
        ${data.bukti_uploaded_at ? `<div class="bm-field"><div class="bm-label">Diupload</div><div class="bm-value" style="font-size:0.78rem;">${data.bukti_uploaded_at}</div></div>` : ''}
      `;

      if (data.bukti_transfer && data.bukti_type === 'image') {
        main.innerHTML = `
          <div style="margin-bottom:0.75rem;">
            <div style="font-size:0.65rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:0.6px;margin-bottom:8px;">Bukti Transfer</div>
            <div class="bm-img-wrap">
              <img src="${data.bukti_transfer}" alt="Bukti Transfer"
                onerror="this.parentElement.innerHTML='<div style=padding:2rem;text-align:center;color:#ff5f5f;font-size:0.85rem;>Gambar tidak dapat dimuat</div>';">
            </div>
            <div style="margin-top:8px;text-align:right;">
              <a href="${data.bukti_transfer}" target="_blank" style="font-size:0.75rem;color:var(--purple2);text-decoration:none;">Buka di tab baru →</a>
            </div>
          </div>
        `;
      } else if (data.bukti_transfer && data.bukti_type === 'pdf') {
        main.innerHTML = `
          <div style="text-align:center;padding:2rem;">
            <div style="font-size:0.85rem;color:var(--text2);margin-bottom:1rem;">Bukti transfer dalam format PDF</div>
            <a href="${data.bukti_transfer}" target="_blank"
              style="display:inline-block;background:var(--grad-primary);color:#fff;padding:10px 20px;border-radius:10px;font-size:0.9rem;font-weight:700;text-decoration:none;">
              Download PDF
            </a>
          </div>
        `;
      } else {
        main.innerHTML = `
          <div class="bm-no-bukti">
            <div style="font-size:0.85rem;color:var(--orange);font-weight:600;">Bukti transfer belum diupload</div>
            <div style="font-size:0.75rem;color:var(--text3);margin-top:6px;">User belum mengirimkan bukti pembayaran.</div>
          </div>
        `;
      }
    })
    .catch(err => {
      main.innerHTML = '<div style="text-align:center;padding:2rem;color:#ff5f5f;">Gagal memuat data.<br><small style="color:var(--text3);">' + err.message + '</small></div>';
    });
}

function bmClose() {
  document.getElementById('bmDetailModal').classList.remove('bm-open');
  document.body.style.overflow = '';
}

document.getElementById('bmDetailModal').addEventListener('click', function(e) {
  if (e.target === this) bmClose();
});
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') bmClose();
});

// ── REAL-TIME LIVE POLLING ────────────────────────────────────────────────
const POLL_URL = '{{ route("admin.check.pending") }}';
const CSRF    = document.querySelector('meta[name="csrf-token"]')?.content;
let   rtSnapshot = '{{ md5($pendingTransactions->pluck("id")->sort()->implode(",")) }}';
let   rtIsFirst  = true;

function rtBuildRow(t) {
  const buktiBadge = t.has_bukti
    ? '<span style="background:rgba(0,212,170,0.15);color:var(--green);padding:2px 8px;border-radius:50px;font-size:0.7rem;font-weight:700;">Ada</span>'
    : '<span style="background:rgba(255,140,66,0.15);color:var(--orange);padding:2px 8px;border-radius:50px;font-size:0.7rem;font-weight:700;">Belum</span>';
  return `
    <tr id="ptr-${t.id}" class="pending-row-new">
      <td><div style="font-weight:700;font-size:0.88rem;">${t.user_name}</div><div style="font-size:0.75rem;color:var(--text2);">${t.user_email}</div></td>
      <td style="font-weight:600;">${t.package_name}</td>
      <td style="font-weight:700;color:var(--purple2);">${t.package_price}</td>
      <td style="color:var(--text2);">${t.ago}</td>
      <td>${buktiBadge}</td>
      <td style="text-align:right;">
        <div style="display:flex;gap:6px;justify-content:flex-end;flex-wrap:wrap;">
          <button type="button" class="approve-btn approve-btn--purple" onclick="bmOpen(${t.id})">Detail</button>
          <form method="POST" action="${t.approve_url}" style="display:inline;"><input type="hidden" name="_token" value="${CSRF}"><button type="submit" class="approve-btn approve-btn--green">Setujui</button></form>
          <form method="POST" action="${t.reject_url}" style="display:inline;"><input type="hidden" name="_token" value="${CSRF}"><button type="submit" class="approve-btn approve-btn--red">Batalkan</button></form>
        </div>
      </td>
    </tr>`;
}

function playAudioChime() {
  try {
    const AudioCtx = window.AudioContext || window.webkitAudioContext;
    if (!AudioCtx) return;
    const ctx = new AudioCtx();

    const playNote = (freq, startTime, duration) => {
      const osc = ctx.createOscillator();
      const gain = ctx.createGain();

      osc.type = 'sine';
      osc.frequency.setValueAtTime(freq, ctx.currentTime + startTime);

      gain.gain.setValueAtTime(0.001, ctx.currentTime + startTime);
      gain.gain.linearRampToValueAtTime(0.12, ctx.currentTime + startTime + 0.03);
      gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + startTime + duration);

      osc.connect(gain);
      gain.connect(ctx.destination);

      osc.start(ctx.currentTime + startTime);
      osc.stop(ctx.currentTime + startTime + duration);
    };

    playNote(659.25, 0, 0.4);   // E5 note
    playNote(987.77, 0.12, 0.6); // B5 note
  } catch (e) {
    console.warn('Audio chime playback error:', e);
  }
}

function rtShowToast(msg) {
  let t = document.getElementById('rtToast');
  if (!t) {
    t = document.createElement('div');
    t.id = 'rtToast';
    t.className = 'rt-toast';
    document.body.appendChild(t);
  }
  t.innerHTML = '<span>' + msg + '</span>';
  t.classList.add('show');
  playAudioChime();
  clearTimeout(t._timer);
  t._timer = setTimeout(() => t.classList.remove('show'), 4000);
}

function rtApplyUpdate(data) {
  if (data.snapshot === rtSnapshot && !rtIsFirst) return; // nothing changed
  rtIsFirst   = false;
  const wasNew = data.snapshot !== rtSnapshot;
  rtSnapshot  = data.snapshot;

  const section = document.getElementById('pendingSection');
  const tbody   = document.getElementById('pendingTbody');
  const badge   = document.getElementById('pendingBadge');

  if (!tbody || !section) return;

  if (data.count === 0) {
    section.style.display = 'none';
    return;
  }
  section.style.display = '';

  // Update badge
  if (badge) badge.textContent = data.count;

  // Figure out which IDs exist in DOM vs in new data
  const newIds   = new Set(data.transactions.map(t => t.id));
  const domRows  = tbody.querySelectorAll('tr[id^="ptr-"]');
  const domIds   = new Set([...domRows].map(r => parseInt(r.id.replace('ptr-', ''))));

  // Remove rows no longer in pending
  domRows.forEach(r => {
    const id = parseInt(r.id.replace('ptr-', ''));
    if (!newIds.has(id)) r.remove();
  });

  // Add rows that are new
  data.transactions.forEach(t => {
    if (!domIds.has(t.id)) {
      tbody.insertAdjacentHTML('afterbegin', rtBuildRow(t));
      if (wasNew) rtShowToast(`Pembayaran baru dari <strong>${t.user_name}</strong>!`);
    } else {
      // Update bukti badge in-place (user may have uploaded bukti after initial load)
      const existingRow = document.getElementById('ptr-' + t.id);
      if (existingRow) {
        const buktiCell = existingRow.cells[4];
        if (t.has_bukti && buktiCell.innerHTML.includes('Belum')) {
          buktiCell.innerHTML = '<span style="background:rgba(0,212,170,0.15);color:var(--green);padding:2px 8px;border-radius:50px;font-size:0.7rem;font-weight:700;">Ada</span>';
          if (wasNew) rtShowToast(`<strong>${t.user_name}</strong> sudah upload bukti transfer!`);
        }
      }
    }
  });
}

function rtPoll() {
  fetch(POLL_URL, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(r => { if (!r.ok) throw new Error(r.status); return r.json(); })
    .then(data => rtApplyUpdate(data))
    .catch(err => console.warn('RT poll error:', err));
}

// Poll every 5 seconds
setInterval(rtPoll, 5000);
</script>
@endsection
