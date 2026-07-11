@extends('layouts.app')
@section('title', 'Admin — Dashboard')

@push('styles')
    <link rel="stylesheet" href="/css/admin.css" />
    <style>
        /* Tabel Pending Payments */
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
        /* Feed Notifikasi */
        .notif-feed { display:flex; flex-direction:column; gap:0; }
        .notif-item { display:flex; align-items:flex-start; gap:10px; padding:10px 0; border-bottom:1px solid var(--border); }
        .notif-item:last-child { border-bottom:none; }
        .notif-dot { width:8px; height:8px; border-radius:50%; margin-top:5px; flex-shrink:0; }
        .notif-dot--pending  { background:var(--orange); box-shadow:0 0 6px rgba(255,140,66,.5); }
        .notif-dot--approved { background:var(--green); }
        .notif-dot--rejected { background:#ff5f5f; }
    </style>
@endpush

@section('content')
<div class="admin-wrap">
  <div class="admin-header">
    <h2>⚙ Admin Dashboard</h2>
    <p>Ringkasan aktivitas platform CS2 Academy</p>
  </div>

  <div class="admin-tabs">
    <a href="{{ route('admin.dashboard') }}" class="admin-tab active">
      <x-cs-icon name="bar-chart" size="14" stroke="2" /> Dashboard
    </a>
    <a href="{{ route('admin.assignments') }}" class="admin-tab">
      <x-cs-icon name="clipboard-list" size="14" stroke="2" /> Tugas User
    </a>
    <a href="{{ route('admin.quiz') }}" class="admin-tab">
      <x-cs-icon name="lightbulb" size="14" stroke="2" /> Kelola Quiz
    </a>
  </div>

  {{-- Flash Messages --}}
  @if(session('success'))
    <div style="background:rgba(0,212,170,0.12);border:1px solid rgba(0,212,170,0.3);border-radius:10px;padding:0.9rem 1.25rem;margin-bottom:1.25rem;font-size:0.875rem;color:var(--green);">
      {{ session('success') }}
    </div>
  @endif

  {{-- Stat Cards --}}
  <div class="stat-grid">
    <div class="stat-card">
      <div class="stat-ic stat-ic--purple"><x-cs-icon name="users" size="20" stroke="1.75" /></div>
      <div class="stat-val">{{ $stats['total_users'] }}</div>
      <div class="stat-label">Total Pemain Terdaftar</div>
    </div>
    <div class="stat-card">
      <div class="stat-ic stat-ic--green"><x-cs-icon name="credit-card" size="20" stroke="1.75" /></div>
      <div class="stat-val">{{ $stats['total_paid'] }}</div>
      <div class="stat-label">Sudah Beli Coaching</div>
    </div>
    <div class="stat-card">
      <div class="stat-ic stat-ic--orange"><x-cs-icon name="clock" size="20" stroke="1.75" /></div>
      <div class="stat-val">{{ $stats['total_pending_payments'] }}</div>
      <div class="stat-label">Pembayaran Menunggu</div>
    </div>
    <div class="stat-card">
      <div class="stat-ic stat-ic--blue"><x-cs-icon name="book-open" size="20" stroke="1.75" /></div>
      <div class="stat-val">{{ $stats['total_courses'] }}</div>
      <div class="stat-label">Total Kursus</div>
    </div>
    <div class="stat-card">
      <div class="stat-ic stat-ic--orange"><x-cs-icon name="lightbulb" size="20" stroke="1.75" /></div>
      <div class="stat-val">{{ $stats['total_quizzes'] }}</div>
      <div class="stat-label">Total Soal Quiz</div>
    </div>
    <div class="stat-card">
      <div class="stat-ic stat-ic--pink"><x-cs-icon name="trophy" size="20" stroke="1.75" /></div>
      <div class="stat-val">{{ $stats['total_completions'] }}</div>
      <div class="stat-label">Kursus Diselesaikan</div>
    </div>
  </div>

  {{-- PENDING PAYMENTS: Tabel Verifikasi --}}
  @if($pendingTransactions->isNotEmpty())
    <div class="dash-card" style="margin-bottom:1.5rem;border:1px solid rgba(255,140,66,0.35);background:rgba(255,140,66,0.04);">
      <h3 style="display:flex;align-items:center;gap:8px;">
        <x-cs-icon name="credit-card" size="16" stroke="2" />
        <span>Pembayaran Menunggu Verifikasi</span>
        <span style="background:var(--orange);color:#fff;font-size:0.65rem;font-weight:700;padding:2px 8px;border-radius:50px;margin-left:4px;">{{ $pendingTransactions->count() }}</span>
      </h3>
      <div style="overflow-x:auto;">
        <table class="pending-table">
          <thead>
            <tr>
              <th>User</th>
              <th>Paket</th>
              <th>Harga</th>
              <th>Waktu Pesan</th>
              <th style="text-align:right;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($pendingTransactions as $trx)
              <tr>
                <td>
                  <div style="font-weight:700;font-size:0.88rem;">{{ $trx->user->name }}</div>
                  <div style="font-size:0.75rem;color:var(--text2);">{{ $trx->user->email }}</div>
                </td>
                <td style="font-weight:600;">{{ $trx->package_name }}</td>
                <td style="font-weight:700;color:var(--purple2);">{{ $trx->package_price }}</td>
                <td style="color:var(--text2);">{{ $trx->created_at->diffForHumans() }}</td>
                <td style="text-align:right;">
                  <div style="display:flex;gap:6px;justify-content:flex-end;">
                    <form method="POST" action="{{ route('admin.coaching.approve', $trx) }}">
                      @csrf
                      <button type="submit" class="approve-btn approve-btn--green">✅ Approve</button>
                    </form>
                    <form method="POST" action="{{ route('admin.coaching.reject', $trx) }}">
                      @csrf
                      <button type="submit" class="approve-btn approve-btn--red">❌ Tolak</button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  @endif

  <div class="dash-grid">
    {{-- Kiri: Status Tugas + Tugas Terbaru --}}
    <div class="dash-col">
      <div class="dash-card">
        <h3><x-cs-icon name="trending-up" size="16" stroke="2" /> Status Tugas User</h3>
        @php $totalA = max($stats['total_assignments'], 1); @endphp
        <div class="status-track">
          <div class="status-seg" style="width:{{ $stats['assignments_menunggu'] / $totalA * 100 }}%;background:var(--orange);"></div>
          <div class="status-seg" style="width:{{ $stats['assignments_diproses'] / $totalA * 100 }}%;background:var(--blue);"></div>
          <div class="status-seg" style="width:{{ $stats['assignments_selesai'] / $totalA * 100 }}%;background:var(--green);"></div>
        </div>
        <div class="status-legend">
          <span><span class="status-dot-legend" style="background:var(--orange);"></span> Menunggu ({{ $stats['assignments_menunggu'] }})</span>
          <span><span class="status-dot-legend" style="background:var(--blue);"></span> Diproses ({{ $stats['assignments_diproses'] }})</span>
          <span><span class="status-dot-legend" style="background:var(--green);"></span> Selesai ({{ $stats['assignments_selesai'] }})</span>
        </div>
      </div>

      <div class="dash-card">
        <h3><x-cs-icon name="file-edit" size="16" stroke="2" /> Tugas Terbaru</h3>
        @forelse($recentAssignments as $item)
          <div class="recent-item">
            <div>
              <div class="recent-title">{{ $item->judul }}</div>
              <div class="recent-sub">{{ $item->user->name }} · {{ $item->created_at->diffForHumans() }}</div>
            </div>
            <span class="status-badge status-{{ $item->status }}">{{ ucfirst($item->status) }}</span>
          </div>
        @empty
          <div class="empty-mini">Belum ada tugas masuk.</div>
        @endforelse
        <div>
          <a href="{{ route('admin.assignments') }}" class="recent-more">Lihat semua tugas →</a>
        </div>
      </div>
    </div>

    {{-- Kanan: Feed Aktivitas Coaching --}}
    <div class="dash-card">
      <h3><x-cs-icon name="credit-card" size="16" stroke="2" /> Aktivitas Pembelian Coaching</h3>
      @forelse($recentCoachingActivity as $activity)
        <div class="notif-item">
          <div class="notif-dot notif-dot--{{ $activity->status }}"></div>
          <div style="flex:1;min-width:0;">
            <div style="font-size:0.875rem;font-weight:600;line-height:1.4;">
              User <strong>{{ $activity->user->name }}</strong> baru saja membeli paket
              <strong style="color:var(--purple2);">{{ $activity->package_name }}</strong>
            </div>
            <div style="display:flex;align-items:center;gap:8px;margin-top:4px;">
              <span style="font-size:0.75rem;color:var(--text3);">{{ $activity->created_at->diffForHumans() }}</span>
              @if($activity->status === 'pending')
                <span style="background:rgba(255,140,66,0.2);color:var(--orange);padding:1px 8px;border-radius:50px;font-size:0.65rem;font-weight:700;">⏳ Pending</span>
              @elseif($activity->status === 'approved')
                <span style="background:rgba(0,212,170,0.15);color:var(--green);padding:1px 8px;border-radius:50px;font-size:0.65rem;font-weight:700;">✅ Disetujui</span>
              @else
                <span style="background:rgba(255,80,80,0.12);color:#ff5f5f;padding:1px 8px;border-radius:50px;font-size:0.65rem;font-weight:700;">❌ Ditolak</span>
              @endif
            </div>
          </div>
          <div style="font-size:0.82rem;font-weight:700;color:var(--purple2);white-space:nowrap;">{{ $activity->package_price }}</div>
        </div>
      @empty
        <div class="empty-mini">Belum ada aktivitas pembelian coaching.</div>
      @endforelse
    </div>
  </div>
</div>
@endsection
