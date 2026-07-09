@extends('layouts.app')
@section('title', 'Admin — Dashboard')

@push('styles')
    <link rel="stylesheet" href="/css/admin.css" />
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
    <div class="stat-card">
      <div class="stat-ic stat-ic--purple"><x-cs-icon name="file-edit" size="20" stroke="1.75" /></div>
      <div class="stat-val">{{ $stats['total_assignments'] }}</div>
      <div class="stat-label">Total Tugas Masuk</div>
    </div>
  </div>

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

    {{-- Kanan: Pembelian Coaching Terbaru --}}
    <div class="dash-card">
      <h3><x-cs-icon name="credit-card" size="16" stroke="2" /> Pembelian Coaching Terbaru</h3>
      @forelse($recentBuyers as $buyer)
        <div class="recent-item">
          <div>
            <div class="recent-title">{{ $buyer->name }}</div>
            <div class="recent-sub">{{ $buyer->email }}</div>
          </div>
          <span class="recent-sub">{{ $buyer->updated_at->diffForHumans() }}</span>
        </div>
      @empty
        <div class="empty-mini">Belum ada user yang beli coaching.</div>
      @endforelse
    </div>
  </div>
</div>
@endsection
