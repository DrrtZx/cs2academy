@extends('layouts.app')
@section('title', 'Admin — Data User')

@push('styles')
    <link rel="stylesheet" href="/css/admin.css" />
    <style>
        .user-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        .user-table th { text-align: left; padding: 10px 14px; font-size: 0.7rem; font-weight: 700; color: var(--text2); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border); background: rgba(0,0,0,0.15); }
        .user-table td { padding: 12px 14px; border-bottom: 1px solid var(--border); vertical-align: middle; }
        .user-table tr:last-child td { border-bottom: none; }
        .user-table tr:hover td { background: rgba(124,111,224,0.04); }

        .badge-sm { font-size: 0.68rem; font-weight: 700; padding: 3px 9px; border-radius: 50px; display: inline-block; }
        .badge-admin { background: rgba(139,123,255,0.15); color: var(--purple2); }
        .badge-user { background: rgba(94,200,255,0.12); color: var(--blue); }
        .badge-paid { background: rgba(43,230,186,0.12); color: var(--green); }
        .badge-free { background: rgba(255,255,255,0.05); color: var(--text3); }

        .search-bar { display: flex; gap: 8px; margin-bottom: 1.25rem; }
        .search-bar input { flex: 1; background: var(--bg3); border: 1px solid var(--border); border-radius: 10px; padding: 10px 14px; color: var(--text); font-size: 14px; outline: none; font-family: inherit; }
        .search-bar input:focus { border-color: var(--purple); }
        .search-bar button { background: var(--grad-primary); border: none; border-radius: 10px; padding: 10px 18px; color: #fff; font-weight: 700; cursor: pointer; font-size: 13px; font-family: inherit; }

        /* Custom Dark Pagination */
        .pg-nav { display: flex; align-items: center; justify-content: space-between; margin-top: 1.25rem; padding-top: 1rem; border-top: 1px solid var(--border); flex-wrap: wrap; gap: 12px; }
        .pg-info { font-size: 0.8rem; color: var(--text2); }
        .pg-info strong { color: var(--text); }
        .pg-links { display: flex; gap: 6px; align-items: center; }
        .pg-item { display: inline-flex; align-items: center; justify-content: center; min-width: 34px; height: 34px; padding: 0 10px; border-radius: 9px; border: 1px solid var(--border); background: var(--bg3); color: var(--text2); font-size: 0.82rem; font-weight: 600; text-decoration: none; transition: all .2s; }
        .pg-item:hover:not(.disabled):not(.active) { border-color: var(--purple2); color: var(--purple2); background: rgba(124,111,224,0.08); }
        .pg-item.active { background: var(--grad-primary); border-color: transparent; color: #fff; font-weight: 800; box-shadow: 0 4px 14px -4px rgba(139,123,255,0.7); }
        .pg-item.disabled { opacity: 0.4; cursor: not-allowed; }
    </style>
@endpush

@section('content')
<div class="admin-wrap">

  <div class="admin-header">
    <h2>Data User & Pemain</h2>
    <p>Kelola seluruh akun terdaftar dan status akses platform CS2 Academy.</p>
  </div>

  <div class="admin-tabs">
    <a href="{{ route('admin.dashboard') }}" class="admin-tab"><x-cs-icon name="bar-chart" size="14" stroke="2" /> Dashboard</a>
    <a href="{{ route('admin.users') }}" class="admin-tab active"><x-cs-icon name="users" size="14" stroke="2" /> User</a>
    <a href="{{ route('admin.assignments') }}" class="admin-tab"><x-cs-icon name="zap" size="14" stroke="2" /> Sesi Coaching</a>
    <a href="{{ route('admin.courses') }}" class="admin-tab"><x-cs-icon name="book-open" size="14" stroke="2" /> Kelola Kursus</a>
  </div>

  @if(session('success'))
    <div style="background:rgba(0,212,170,0.12);border:1px solid rgba(0,212,170,0.3);border-radius:10px;padding:0.9rem 1.25rem;margin-bottom:1.25rem;font-size:0.875rem;color:var(--green);">{{ session('success') }}</div>
  @endif

  {{-- Overview Stat Cards --}}
  <div class="stat-grid">
    <div class="stat-card">
      <div class="stat-ic stat-ic--purple"><x-cs-icon name="users" size="20" stroke="1.75" /></div>
      <div class="stat-val">{{ $stats['total'] }}</div>
      <div class="stat-label">Total User</div>
    </div>
    <div class="stat-card">
      <div class="stat-ic stat-ic--blue"><x-cs-icon name="settings" size="20" stroke="1.75" /></div>
      <div class="stat-val">{{ $stats['admin'] }}</div>
      <div class="stat-label">Admin</div>
    </div>
    <div class="stat-card">
      <div class="stat-ic stat-ic--orange"><x-cs-icon name="user" size="20" stroke="1.75" /></div>
      <div class="stat-val">{{ $stats['user'] }}</div>
      <div class="stat-label">Pemain CS2</div>
    </div>
    <div class="stat-card">
      <div class="stat-ic stat-ic--green"><x-cs-icon name="credit-card" size="20" stroke="1.75" /></div>
      <div class="stat-val">{{ $stats['paid'] }}</div>
      <div class="stat-label">User Paid</div>
    </div>
  </div>

  {{-- Table Card --}}
  <div class="dash-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;flex-wrap:wrap;gap:12px;">
      <h3 style="margin:0;"><x-cs-icon name="users" size="16" stroke="2" /> Daftar Pemain Terdaftar</h3>

      {{-- Search Form --}}
      <form method="GET" action="{{ route('admin.users') }}" class="search-bar" style="margin:0;max-width:360px;width:100%;">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau email...">
        <button type="submit">Cari</button>
        @if($search)
          <a href="{{ route('admin.users') }}" style="background:var(--bg3);border:1px solid var(--border);border-radius:10px;padding:10px 14px;color:var(--text2);font-size:13px;font-weight:600;text-decoration:none;display:flex;align-items:center;">✕</a>
        @endif
      </form>
    </div>

    {{-- Table --}}
    <div style="overflow-x:auto;">
      <table class="user-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama User</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Paket Aktif</th>
            <th>Bergabung</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $i => $u)
          <tr>
            <td style="color:var(--text3);font-size:0.8rem;">{{ $users->firstItem() + $i }}</td>
            <td>
              <div style="display:flex;align-items:center;gap:10px;">
                <span style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,var(--purple),var(--cyan));display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:800;color:#fff;flex-shrink:0;">{{ strtoupper(mb_substr($u->name, 0, 1)) }}</span>
                <span style="font-weight:700;color:var(--text);">{{ $u->name }}</span>
              </div>
            </td>
            <td style="color:var(--text2);font-size:0.82rem;">{{ $u->email }}</td>
            <td>
              <span class="badge-sm {{ $u->isAdmin() ? 'badge-admin' : 'badge-user' }}">{{ $u->isAdmin() ? 'Admin' : 'User' }}</span>
            </td>
            <td>
              <span class="badge-sm {{ $u->has_paid ? 'badge-paid' : 'badge-free' }}">{{ $u->has_paid ? 'Paid' : 'Free' }}</span>
            </td>
            <td style="font-size:0.82rem;color:var(--text2);">{{ $u->active_coaching_package ?? '—' }}</td>
            <td style="font-size:0.78rem;color:var(--text3);">{{ $u->created_at->format('d M Y') }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="7" style="text-align:center;padding:3rem;color:var(--text3);">
              Tidak ada user ditemukan.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Clean Custom Dark Pagination --}}
    @if($users->hasPages())
      <div class="pg-nav">
        <div class="pg-info">
          Menampilkan <strong>{{ $users->firstItem() }} - {{ $users->lastItem() }}</strong> dari <strong>{{ $users->total() }}</strong> user
        </div>
        <div class="pg-links">
          {{-- Previous Button --}}
          @if ($users->onFirstPage())
            <span class="pg-item disabled">← Sebelumnya</span>
          @else
            <a href="{{ $users->previousPageUrl() }}" class="pg-item">← Sebelumnya</a>
          @endif

          {{-- Page Numbers --}}
          @foreach ($users->getUrlRange(max(1, $users->currentPage() - 2), min($users->lastPage(), $users->currentPage() + 2)) as $page => $url)
            @if ($page == $users->currentPage())
              <span class="pg-item active">{{ $page }}</span>
            @else
              <a href="{{ $url }}" class="pg-item">{{ $page }}</a>
            @endif
          @endforeach

          {{-- Next Button --}}
          @if ($users->hasMorePages())
            <a href="{{ $url = $users->nextPageUrl() }}" class="pg-item">Berikutnya →</a>
          @else
            <span class="pg-item disabled">Berikutnya →</span>
          @endif
        </div>
      </div>
    @endif

  </div>

</div>
@endsection
