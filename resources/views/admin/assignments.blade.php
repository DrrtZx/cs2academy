@extends('layouts.app')
@section('title', 'Admin Panel')

@push('styles')
    <link rel="stylesheet" href="/css/admin.css" />
@endpush

@section('content')
<div class="admin-wrap admin-wrap--narrow">

  <div class="admin-header">
    <h2><x-cs-icon name="settings" size="20" stroke="2" /> Admin Panel</h2>
    <p>Kelola tugas user dan konten quiz kursus</p>
  </div>

  <div class="admin-tabs">
    <a href="{{ route('admin.dashboard') }}" class="admin-tab">
      <x-cs-icon name="bar-chart" size="14" stroke="2" /> Dashboard
    </a>
    <a href="{{ route('admin.assignments') }}" class="admin-tab active">
      <x-cs-icon name="clipboard-list" size="14" stroke="2" /> Tugas User
      <span class="admin-tab-badge">{{ $assignments->count() }}</span>
    </a>
    <a href="{{ route('admin.quiz') }}" class="admin-tab">
      <x-cs-icon name="lightbulb" size="14" stroke="2" /> Kelola Quiz
    </a>
  </div>

  @forelse($assignments as $item)
    <div class="admin-card">
      <div class="admin-card-header">
        <div>
          <div class="admin-card-title">{{ $item->judul }}</div>
          <div class="admin-card-meta">
            Dari: <strong>{{ $item->user->name }}</strong>
            · {{ $item->user->email }}
            · {{ $item->created_at->diffForHumans() }}
          </div>
        </div>
        <div class="admin-card-actions">
          <span class="status-badge status-{{ $item->status }}">
            @if($item->status === 'menunggu')
                <x-cs-icon name="clock" size="11" stroke="2" /> Menunggu
            @elseif($item->status === 'diproses')
                <x-cs-icon name="refresh" size="11" stroke="2" /> Diproses
            @else
                <x-cs-icon name="check" size="11" stroke="2.5" /> Selesai
            @endif
          </span>
          <form method="POST" action="{{ route('admin.assignments.delete', $item) }}" onsubmit="return confirm('Hapus tugas ini? Aksi ini tidak bisa dibatalkan.')">
            @csrf @method('DELETE')
            <button type="submit" class="del-btn" title="Hapus tugas ini">
                <x-cs-icon name="trash" size="13" stroke="2" /> Hapus
            </button>
          </form>
        </div>
      </div>

      <div class="task-body">
        <div class="task-body-label">Isi Pertanyaan / Tugas:</div>
        <p class="task-body-text">{{ $item->tugas_teks }}</p>
      </div>

      <form method="POST" action="{{ route('admin.assignments.update', $item) }}">
        @csrf
        <div class="reply-label">Balasan ke User:</div>
        <textarea name="balasan_admin" class="f-inp" placeholder="Tulis feedback/balasan untuk user ini...">{{ old('balasan_admin', $item->balasan_admin) }}</textarea>

        <div class="reply-row">
          <div class="reply-status-col">
            <div class="reply-label">Status:</div>
            <select name="status" class="f-inp">
              <option value="menunggu"  {{ $item->status==='menunggu'  ? 'selected':'' }}>Menunggu</option>
              <option value="diproses"  {{ $item->status==='diproses'  ? 'selected':'' }}>Diproses</option>
              <option value="selesai"   {{ $item->status==='selesai'   ? 'selected':'' }}>Selesai</option>
            </select>
          </div>
          <div class="reply-btn-col">
            <button type="submit" class="save-btn">
                <x-cs-icon name="save" size="14" stroke="2" /> Simpan Balasan
            </button>
          </div>
        </div>
      </form>
    </div>
  @empty
    <div class="empty-state">
      <div class="empty-state-icon">
        <span>
            <x-cs-icon name="inbox" size="28" stroke="1.5" />
        </span>
      </div>
      <p>Belum ada tugas yang masuk dari user.</p>
    </div>
  @endforelse

</div>
@endsection
