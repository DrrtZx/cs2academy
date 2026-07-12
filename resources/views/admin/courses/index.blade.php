@php
$isModulesView = isset($course);
$allCourses = $isModulesView ? null : $courses;
@endphp

@extends('layouts.app')
@section('title', $isModulesView ? 'Admin — Modul: ' . $course->title : 'Admin — Kelola Kursus')

@push('styles')
<style>
.cw { max-width: 980px; margin: 0 auto; padding: 2.5rem 2rem; }
.topbar { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 24px; gap: 16px; flex-wrap: wrap; }
.crumb { font-size: 13px; color: var(--text3); margin-bottom: 8px; }
.crumb a { color: var(--purple2); text-decoration: none; cursor: pointer; }
.crumb a:hover { text-decoration: underline; }
.crumb b { color: var(--text2); font-weight: 500; }
.page-title { font-size: 22px; font-weight: 800; margin: 0 0 4px; color: var(--text); }
.page-sub { font-size: 13.5px; color: var(--text2); margin: 0; }

.btn { border: none; border-radius: 10px; padding: 11px 18px; font-size: 13.5px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; font-family: inherit; transition: all .15s; text-decoration: none; }
.btn-pri { background: var(--grad-primary); color: #fff; box-shadow: 0 8px 18px -9px rgba(139,123,255,.6); }
.btn-pri:hover { filter: brightness(1.08); transform: translateY(-1px); }
.btn-ghost { background: rgba(255,255,255,0.04); color: var(--text); border: 1px solid var(--border); }
.btn-ghost:hover { border-color: var(--purple); }
.btn-sm { padding: 7px 12px; font-size: 12px; border-radius: 8px; }

.btn-icon { background: rgba(255,255,255,0.04); border: 1px solid var(--border); color: var(--text2); width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; font-size: 13px; font-family: inherit; transition: all .15s; }
.btn-icon:hover { color: var(--text); border-color: var(--purple); }
.btn-icon.danger:hover { color: var(--red); border-color: rgba(255,114,114,0.4); }

.card-list { display: flex; flex-direction: column; gap: 10px; }
.row-card { background: var(--bg2); border: 1px solid var(--border); border-radius: 14px; padding: 16px 18px; display: flex; align-items: center; gap: 14px; transition: border-color .15s; }
.row-card:hover { border-color: rgba(139,123,255,0.3); }
.row-icon { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, rgba(139,123,255,0.22), rgba(63,216,255,0.16)); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
.row-body { flex: 1; min-width: 0; }
.row-title { font-size: 14.5px; font-weight: 700; color: var(--text); }
.row-sub { font-size: 12px; color: var(--text3); margin-top: 2px; }
.row-actions { display: flex; gap: 6px; flex-shrink: 0; }
.badge { font-size: 10.5px; font-weight: 700; padding: 3px 9px; border-radius: 999px; display: inline-block; margin-left: 6px; vertical-align: middle; }
.badge-lvl { background: rgba(139,123,255,0.16); color: var(--purple2); }
.badge-pop { background: rgba(255,171,92,0.16); color: var(--orange); }
.badge-type { background: rgba(94,200,255,0.14); color: var(--blue); }

.reorder { display: flex; flex-direction: column; gap: 1px; flex-shrink: 0; }
.reorder button { background: none; border: none; color: var(--text3); cursor: pointer; font-size: 11px; padding: 3px 5px; font-family: inherit; line-height: 1; }
.reorder button:hover { color: var(--text); }

.modal-overlay { position: fixed; inset: 0; background: rgba(5,7,15,0.72); backdrop-filter: blur(3px); display: none; align-items: center; justify-content: center; z-index: 100; padding: 24px; }
.modal-overlay.show { display: flex; }
.modal { background: var(--bg2); border: 1px solid var(--border); border-radius: 18px; width: 100%; max-width: 660px; max-height: 88vh; overflow-y: auto; padding: 26px 28px; }
.modal-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.modal-title { font-size: 17px; font-weight: 800; margin: 0; color: var(--text); }
.modal-close { background: none; border: none; color: var(--text3); font-size: 18px; cursor: pointer; padding: 4px 8px; }

.field { margin-bottom: 18px; }
.field label { display: block; font-size: 12px; font-weight: 700; color: var(--text2); text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 8px; }
.field input[type=text], .field input[type=url], .field textarea, .field select {
  width: 100%; background: var(--bg3); border: 1px solid var(--border); border-radius: 10px;
  padding: 11px 13px; color: var(--text); font-size: 14px; font-family: inherit;
}
.field input:focus, .field textarea:focus, .field select:focus { outline: none; border-color: var(--purple); }
.field textarea { resize: vertical; min-height: 70px; }
.field-hint { font-size: 11.5px; color: var(--text3); margin-top: 6px; }
.field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

.modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 22px; padding-top: 18px; border-top: 1px solid var(--border); }

.admin-tabs { display: flex; gap: 8px; margin-bottom: 28px; flex-wrap: wrap; }
.admin-tab { padding: 9px 20px; border-radius: 9px; border: 1px solid var(--border); background: var(--bg2); color: var(--text2); font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all .2s; text-decoration: none; display: inline-flex; align-items: center; gap: 7px; }
.admin-tab:hover, .admin-tab.active { background: var(--grad-primary); border-color: transparent; color: #fff; }
</style>
@endpush

@section('content')
<div class="cw">

  {{-- Flash --}}
  @if(session('success'))
    <div style="background:rgba(43,230,186,0.1);border:1px solid rgba(43,230,186,0.3);border-radius:10px;padding:0.9rem 1.25rem;margin-bottom:1.25rem;font-size:0.875rem;color:var(--green);">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div style="background:rgba(255,114,114,0.1);border:1px solid rgba(255,114,114,0.3);border-radius:10px;padding:0.9rem 1.25rem;margin-bottom:1.25rem;font-size:0.875rem;color:var(--red);">{{ session('error') }}</div>
  @endif

  {{-- Tabs --}}
  <div class="admin-tabs">
    <a href="{{ route('admin.dashboard') }}" class="admin-tab"><x-cs-icon name="bar-chart" size="14" stroke="2" /> Dashboard</a>
    <a href="{{ route('admin.assignments') }}" class="admin-tab"><x-cs-icon name="clipboard-list" size="14" stroke="2" /> Tugas User</a>
    <a href="{{ route('admin.courses') }}" class="admin-tab active"><x-cs-icon name="book-open" size="14" stroke="2" /> Kelola Course</a>
  </div>

  {{-- ═══════════ VIEW: LIST MODULE (Level 2) ═══════════ --}}
  @if($isModulesView)
    <div class="topbar">
      <div>
        <div class="crumb"><a href="{{ route('admin.courses') }}">Kelola Kursus</a> › <b>{{ $course->title }}</b></div>
        <h2 class="page-title">Modul dalam Kursus Ini</h2>
        <p class="page-sub">Urutan modul menentukan urutan unlock berjenjang buat user. Geser naik-turun buat atur ulang.</p>
      </div>
      <a href="{{ route('admin.modules.create', $course) }}" class="btn btn-pri">+ Tambah Modul</a>
    </div>

    <div class="card-list">
      @forelse($modules as $idx => $mod)
      <div class="row-card">
        <div class="reorder">
          <form method="POST" action="{{ route('admin.modules.reorder', $mod) }}" style="margin:0;">
            @csrf
            <input type="hidden" name="direction" value="up">
            <button type="submit" {{ $idx === 0 ? 'disabled style=opacity:0.3' : '' }}>▲</button>
          </form>
          <form method="POST" action="{{ route('admin.modules.reorder', $mod) }}" style="margin:0;">
            @csrf
            <input type="hidden" name="direction" value="down">
            <button type="submit" {{ $idx === $modules->count() - 1 ? 'disabled style=opacity:0.3' : '' }}>▼</button>
          </form>
        </div>
        <div class="row-icon">{{ $idx + 1 }}</div>
        <div class="row-body">
          <div class="row-title">{{ $mod->title }}</div>
          <div class="row-sub">{{ $mod->quizzes_count }} soal kuis{{ $mod->youtube_url ? ' · 🎥 Ada video' : '' }}</div>
        </div>
        <div class="row-actions">
          <a href="{{ route('admin.modules.edit', $mod) }}" class="btn-icon" title="Edit modul">✎</a>
          <form method="POST" action="{{ route('admin.modules.delete', $mod) }}" onsubmit="return confirm('Hapus modul ini? Quiz di dalamnya juga ikut kehapus.')" style="margin:0;">
            @csrf @method('DELETE')
            <button type="submit" class="btn-icon danger" title="Hapus modul">🗑</button>
          </form>
        </div>
      </div>
      @empty
      <div style="text-align:center;padding:3rem;color:var(--text3);background:var(--bg2);border:1px dashed var(--border);border-radius:14px;">
        <div style="font-size:2rem;margin-bottom:0.5rem;">📭</div>
        <p style="font-weight:600;">Belum ada modul</p>
        <p style="font-size:0.82rem;">Klik "+ Tambah Modul" buat mulai.</p>
      </div>
      @endforelse
    </div>

  {{-- ═══════════ VIEW: LIST COURSE (Level 1) ═══════════ --}}
  @else
    <div class="topbar">
      <div>
        <div class="crumb">Admin › <b>Kelola Kursus</b></div>
        <h2 class="page-title">Kelola Kursus</h2>
        <p class="page-sub">Atur kursus, modul, dan kuis yang tampil di halaman Kursus.</p>
      </div>
      <a href="{{ route('admin.courses.create') }}" class="btn btn-pri">+ Tambah Kursus</a>
    </div>

    <div class="card-list">
      @forelse($allCourses as $c)
      <div class="row-card">
        <div class="row-icon">{{ $c->icon }}</div>
        <div class="row-body">
          <div class="row-title">
            {{ $c->title }}
            <span class="badge badge-lvl">{{ $c->level }}</span>
            @if($c->is_popular)<span class="badge badge-pop">🔥 Populer</span>@endif
            <span class="badge badge-type">{{ $c->type }}</span>
          </div>
          <div class="row-sub">{{ $c->modules_count }} modul · {{ $c->quizzes_count }} soal kuis · {{ $c->durasi }}</div>
        </div>
        <div class="row-actions">
          <a href="{{ route('admin.courses.modules', $c) }}" class="btn btn-ghost btn-sm">Kelola Modul</a>
          <a href="{{ route('admin.courses.edit', $c) }}" class="btn-icon" title="Edit kursus">✎</a>
          <form method="POST" action="{{ route('admin.courses.delete', $c) }}" onsubmit="return confirm('Hapus kursus ini?')" style="margin:0;">
            @csrf @method('DELETE')
            <button type="submit" class="btn-icon danger" title="Hapus kursus">🗑</button>
          </form>
        </div>
      </div>
      @empty
      <div style="text-align:center;padding:3rem;color:var(--text3);background:var(--bg2);border:1px dashed var(--border);border-radius:14px;">
        <div style="font-size:2rem;margin-bottom:0.5rem;">📚</div>
        <p style="font-weight:600;">Belum ada kursus</p>
        <p style="font-size:0.82rem;">Klik "+ Tambah Kursus" buat mulai.</p>
      </div>
      @endforelse
    </div>
  @endif

</div>
@endsection
