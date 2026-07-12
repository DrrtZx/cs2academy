@extends('layouts.app')
@section('title', 'Admin — User')

@push('styles')
<style>
.cw { max-width: 1000px; margin: 0 auto; padding: 2.5rem 2rem; }

.admin-tabs { display: flex; gap: 8px; margin-bottom: 28px; flex-wrap: wrap; }
.admin-tab { padding: 9px 20px; border-radius: 9px; border: 1px solid var(--border); background: var(--bg2); color: var(--text2); font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all .2s; text-decoration: none; display: inline-flex; align-items: center; gap: 7px; }
.admin-tab:hover, .admin-tab.active { background: var(--grad-primary); border-color: transparent; color: #fff; }

.user-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; background: var(--bg2); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; }
.user-table th { text-align: left; padding: 10px 14px; font-size: 0.7rem; font-weight: 700; color: var(--text2); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border); background: var(--bg3); }
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

.summary-bar { display: flex; gap: 20px; padding: 12px 16px; background: var(--bg2); border: 1px solid var(--border); border-radius: 10px; margin-bottom: 1.25rem; font-size: 0.8rem; color: var(--text2); flex-wrap: wrap; }
.summary-bar strong { color: var(--text); }

.pagination { display: flex; gap: 6px; margin-top: 1rem; justify-content: center; }
.pagination a, .pagination span { padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 600; text-decoration: none; border: 1px solid var(--border); color: var(--text2); background: var(--bg2); }
.pagination span { background: var(--grad-primary); color: #fff; border-color: transparent; }
.pagination a:hover { border-color: var(--purple); }
</style>
@endpush

@section('content')
<div class="cw">

  @if(session('success'))
    <div style="background:rgba(43,230,186,0.1);border:1px solid rgba(43,230,186,0.3);border-radius:10px;padding:0.9rem 1.25rem;margin-bottom:1.25rem;font-size:0.875rem;color:var(--green);">{{ session('success') }}</div>
  @endif

  <div class="admin-tabs">
    <a href="{{ route('admin.dashboard') }}" class="admin-tab"><x-cs-icon name="bar-chart" size="14" stroke="2" /> Dashboard</a>
    <a href="{{ route('admin.users') }}" class="admin-tab active"><x-cs-icon name="users" size="14" stroke="2" /> User</a>
    <a href="{{ route('admin.assignments') }}" class="admin-tab"><x-cs-icon name="zap" size="14" stroke="2" /> Sesi Coaching</a>
    <a href="{{ route('admin.courses') }}" class="admin-tab"><x-cs-icon name="book-open" size="14" stroke="2" /> Kelola Course</a>
  </div>

  <h2 style="font-size:1.4rem;font-weight:800;margin-bottom:0.3rem;">👤 Data User</h2>
  <p style="color:var(--text2);font-size:0.875rem;margin-bottom:1.5rem;">Semua user terdaftar di platform CS2 Academy.</p>

  {{-- Search --}}
  <form method="GET" action="{{ route('admin.users') }}" class="search-bar">
    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau email...">
    <button type="submit">🔍 Cari</button>
    @if($search)
      <a href="{{ route('admin.users') }}" class="btn" style="background:var(--bg3);border:1px solid var(--border);border-radius:10px;padding:10px 14px;color:var(--text2);font-size:13px;font-weight:600;text-decoration:none;display:flex;align-items:center;">✕</a>
    @endif
  </form>

  {{-- Summary --}}
  <div class="summary-bar">
    <span>Total: <strong>{{ $users->total() }}</strong></span>
    <span>Admin: <strong>{{ $users->filter(fn($u) => $u->isAdmin())->count() }}</strong></span>
    <span>User: <strong>{{ $users->filter(fn($u) => !$u->isAdmin())->count() }}</strong></span>
    <span>💳 Paid: <strong>{{ $users->filter(fn($u) => $u->has_paid)->count() }}</strong></span>
  </div>

  {{-- Table --}}
  <table class="user-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Nama</th>
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
        <td style="color:var(--text3);">{{ $users->firstItem() + $i }}</td>
        <td>
          <div style="display:flex;align-items:center;gap:8px;">
            <span style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,var(--purple),var(--cyan));display:flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:700;color:#fff;flex-shrink:0;">{{ strtoupper(mb_substr($u->name, 0, 1)) }}</span>
            <span style="font-weight:600;">{{ $u->name }}</span>
          </div>
        </td>
        <td style="color:var(--text2);font-size:0.8rem;">{{ $u->email }}</td>
        <td>
          <span class="badge-sm {{ $u->isAdmin() ? 'badge-admin' : 'badge-user' }}">{{ $u->isAdmin() ? 'Admin' : 'User' }}</span>
        </td>
        <td>
          <span class="badge-sm {{ $u->has_paid ? 'badge-paid' : 'badge-free' }}">{{ $u->has_paid ? '✅ Paid' : '🔒 Free' }}</span>
        </td>
        <td style="font-size:0.8rem;color:var(--text2);">{{ $u->active_coaching_package ?? '—' }}</td>
        <td style="font-size:0.78rem;color:var(--text3);">{{ $u->created_at->format('d M Y') }}</td>
      </tr>
      @empty
      <tr><td colspan="7" style="text-align:center;padding:2.5rem;color:var(--text3);">Tidak ada user ditemukan.</td></tr>
      @endforelse
    </tbody>
  </table>

  {{-- Pagination --}}
  @if($users->hasPages())
    <div class="pagination">
      {{ $users->appends(['search' => $search])->onEachSide(1)->links('pagination::simple') }}
    </div>
  @endif

</div>
@endsection
