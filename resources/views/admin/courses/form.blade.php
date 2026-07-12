@php
$isEdit = $mode === 'edit';
$formAction = $isEdit
    ? route('admin.courses.update', $course)
    : route('admin.courses.store');
$pageTitle = $isEdit ? 'Edit Kursus: ' . $course->title : 'Tambah Kursus Baru';
$crumbTitle = $isEdit ? 'Edit: ' . \Illuminate\Support\Str::limit($course->title, 35) : 'Tambah Kursus Baru';
@endphp

@extends('layouts.app')
@section('title', $pageTitle)

@push('styles')
<style>
.wrap { max-width: 680px; margin: 0 auto 60px; padding: 2rem; }
.crumb { font-size: 13px; color: var(--text3); margin-bottom: 6px; }
.crumb b { color: var(--text2); font-weight: 500; }
.crumb a { color: var(--cyan); text-decoration: none; }
.page-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 26px; flex-wrap: wrap; gap: 14px; }
.page-title { font-size: 23px; font-weight: 800; margin: 4px 0 0; color: var(--text); }
.page-sub { font-size: 13.5px; color: var(--text2); margin-top: 4px; }

.btn { border: none; border-radius: 10px; padding: 11px 18px; font-size: 13.5px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; font-family: inherit; transition: all .15s; text-decoration: none; }
.btn-primary { background: var(--grad-primary); color: #fff; }
.btn-primary:hover { filter: brightness(1.08); }
.btn-ghost { background: var(--bg3); color: var(--text); border: 1px solid var(--border); }
.btn-ghost:hover { border-color: var(--purple); }
.btn-sm { padding: 8px 14px; font-size: 12.5px; border-radius: 8px; }

.section { background: var(--bg2); border: 1px solid var(--border); border-radius: 16px; padding: 24px 26px; margin-bottom: 20px; }
.section-title { font-size: 12px; font-weight: 700; color: var(--text2); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }

.field { margin-bottom: 18px; }
.field:last-child { margin-bottom: 0; }
.field label { display: block; font-size: 12px; font-weight: 700; color: var(--text2); text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 8px; }
.field input[type=text], .field textarea, .field select {
  width: 100%; background: var(--bg3); border: 1px solid var(--border); border-radius: 10px;
  padding: 12px 14px; color: var(--text); font-size: 14px; font-family: inherit;
}
.field input:focus, .field textarea:focus, .field select:focus { outline: none; border-color: var(--purple); }
.field textarea { resize: vertical; min-height: 70px; }
.field-hint { font-size: 11.5px; color: var(--text3); margin-top: 6px; }

.field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

.icon-picker { display: flex; align-items: center; gap: 12px; }
.icon-preview {
  width: 52px; height: 52px; border-radius: 12px; flex-shrink: 0;
  background: linear-gradient(135deg, rgba(139,123,255,0.22), rgba(63,216,255,0.16));
  display: flex; align-items: center; justify-content: center; font-size: 24px;
}
.icon-picker input { flex: 1; }

.checkbox-row { display: flex; align-items: center; gap: 10px; }
.checkbox-row input[type=checkbox] { width: 18px; height: 18px; accent-color: var(--purple); cursor: pointer; }
.checkbox-row label { margin: 0; text-transform: none; font-size: 14px; color: var(--text); font-weight: 500; letter-spacing: 0; cursor: pointer; }

.preview-card {
  background: var(--bg3); border: 1px solid var(--border); border-radius: 14px; padding: 18px 20px;
  display: flex; align-items: center; gap: 14px;
}
.preview-card .icon-preview { width: 44px; height: 44px; font-size: 20px; }
.preview-card-body { flex: 1; min-width: 0; }
.preview-card-title { font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
.preview-card-meta { font-size: 12px; color: var(--text3); display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
.mini-badge { font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 999px; background: rgba(139,123,255,0.15); color: var(--purple2); }
.mini-badge.popular { background: rgba(255,171,92,0.15); color: var(--orange); }

.sticky-footer {
  position: sticky; bottom: 16px; margin-top: 24px;
  background: var(--bg2); border: 1px solid var(--border); border-radius: 14px;
  padding: 16px 20px; display: flex; justify-content: flex-end; gap: 10px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.4);
}
</style>
@endpush

@section('content')
<div class="wrap">

  @if($errors->any())
    <div style="background:rgba(255,114,114,0.1);border:1px solid rgba(255,114,114,0.3);border-radius:10px;padding:0.9rem 1.25rem;margin-bottom:1.25rem;font-size:0.875rem;color:var(--red);">
      @foreach($errors->all() as $err)<div>{{ $err }}</div>@endforeach
    </div>
  @endif

  <div class="crumb">
    <a href="{{ route('admin.courses') }}">Kelola Kursus</a> › <b>{{ $crumbTitle }}</b>
  </div>

  <div class="page-head">
    <div>
      <h1 class="page-title">{{ $pageTitle }}</h1>
      <p class="page-sub">Kursus akan muncul di halaman Katalog Kursus (/courses) setelah disimpan.</p>
    </div>
    <a href="{{ route('admin.courses') }}" class="btn btn-ghost btn-sm">← Kembali ke Kelola Kursus</a>
  </div>

  <form method="POST" action="{{ $formAction }}" id="course-form">
    @csrf
    @if($isEdit) @method('PUT') @endif

    {{-- ═══ INFO DASAR KURSUS ═══ --}}
    <div class="section">
      <div class="section-title">📚 Info Dasar Kursus</div>

      <div class="field">
        <label>Icon & Nama Kursus</label>
        <div class="icon-picker">
          <div class="icon-preview" id="icon-preview">{{ old('icon', $isEdit ? $course->icon : '🎯') }}</div>
          <input type="text" name="icon" id="icon-input"
                 value="{{ old('icon', $isEdit ? $course->icon : '') }}"
                 maxlength="10" style="max-width:70px; text-align:center;"
                 oninput="syncPreview()" placeholder="🎯" required>
          <input type="text" name="title" id="title-input"
                 value="{{ old('title', $isEdit ? $course->title : '') }}"
                 style="flex:1;" oninput="syncPreview()"
                 placeholder="Contoh: Aim & Movement" required>
        </div>
        <div class="field-hint">Icon berupa emoji tunggal, tampil di card katalog kursus.</div>
      </div>

      <div class="field">
        <label>Deskripsi Singkat</label>
        <textarea name="body" id="desc-input" oninput="syncPreview()"
                  placeholder="Fondasi utama CS2 — crosshair placement, counter-strafing, dan spray control." required>{{ old('body', $isEdit ? $course->body : '') }}</textarea>
      </div>

      <div class="field-row">
        <div class="field">
          <label>Level</label>
          <select name="level" id="level-input" onchange="syncPreview()">
            @php $lvl = old('level', $isEdit ? $course->level : 'Pemula'); @endphp
            <option {{ $lvl === 'Pemula' ? 'selected' : '' }}>Pemula</option>
            <option {{ $lvl === 'Menengah' ? 'selected' : '' }}>Menengah</option>
            <option {{ $lvl === 'Lanjutan' ? 'selected' : '' }}>Lanjutan</option>
          </select>
        </div>
        <div class="field">
          <label>Durasi Estimasi</label>
          <input type="text" name="durasi" id="durasi-input"
                 value="{{ old('durasi', $isEdit ? $course->durasi : '') }}"
                 placeholder="Contoh: 45 menit / 1 jam" required>
        </div>
      </div>

      <div class="field-row">
        <div class="field">
          <label>Tipe Kursus</label>
          <select name="type" id="type-input" onchange="syncPreview()">
            @php $typ = old('type', $isEdit ? $course->type : 'Kursus Wajib'); @endphp
            <option {{ $typ === 'Kursus Wajib' ? 'selected' : '' }}>Kursus Wajib</option>
            <option {{ $typ === 'Kursus Lanjutan' ? 'selected' : '' }}>Kursus Lanjutan</option>
          </select>
        </div>
        <div class="field">
          <label>Urutan Tampil</label>
          <input type="text" name="urutan" id="urutan-input"
                 value="{{ old('urutan', $isEdit ? $course->urutan : $allCourses->count()) }}"
                 placeholder="Contoh: 1 (paling awal)" required>
          <div class="field-hint">Menentukan posisi & urutan unlock di katalog.</div>
        </div>
      </div>

      <div class="field checkbox-row">
        <input type="checkbox" name="is_popular" id="popular-input" value="1"
               onchange="syncPreview()"
               {{ old('is_popular', $isEdit && $course->is_popular ? true : false) ? 'checked' : '' }}>
        <label for="popular-input">Tandai sebagai "🔥 Populer" (badge tampil di card katalog)</label>
      </div>
    </div>

    {{-- ═══ PRASYARAT ═══ --}}
    <div class="section">
      <div class="section-title">🔒 Prasyarat Akses</div>
      <div class="field" style="margin-bottom:0;">
        <label>Kursus Prasyarat (opsional)</label>
        <select name="prerequisite_course_id" id="prereq-input">
          <option value="">— Tidak ada, bisa langsung diakses —</option>
          @foreach($allCourses as $pc)
            @php $sel = old('prerequisite_course_id', $isEdit && $course->prerequisite_course_id === $pc->id ? $pc->id : null); @endphp
            <option value="{{ $pc->id }}" {{ $sel == $pc->id ? 'selected' : '' }}>{{ $pc->title }}</option>
          @endforeach
        </select>
        <div class="field-hint">Kursus ini akan terkunci di katalog sampai kursus prasyarat diselesaikan user. Kosongkan untuk urutan unlock berjenjang otomatis berdasarkan Urutan Tampil.</div>
      </div>
    </div>

    {{-- ═══ PREVIEW LIVE ═══ --}}
    <div class="section">
      <div class="section-title">👁 Preview Card di Katalog</div>
      <div class="preview-card">
        <div class="icon-preview" id="preview-icon">{{ old('icon', $isEdit ? $course->icon : '🎯') }}</div>
        <div class="preview-card-body">
          <div class="preview-card-title" id="preview-title">{{ old('title', $isEdit ? $course->title : 'Nama kursus...') }}</div>
          <div class="preview-card-meta">
            <span class="mini-badge" id="preview-level">{{ old('level', $isEdit ? $course->level : 'Pemula') }}</span>
            <span class="mini-badge" id="preview-type">{{ old('type', $isEdit ? $course->type : 'Kursus Wajib') }}</span>
            <span class="mini-badge popular" id="preview-popular" style="display:{{ (old('is_popular', $isEdit && $course->is_popular ? true : false)) ? 'inline-block' : 'none' }};">🔥 Populer</span>
          </div>
        </div>
      </div>
    </div>

    <div class="sticky-footer">
      <a href="{{ route('admin.courses') }}" class="btn btn-ghost">Batal</a>
      <button type="submit" class="btn btn-primary">💾 Simpan Kursus</button>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
function syncPreview() {
  var icon = document.getElementById('icon-input').value || '🎯';
  var title = document.getElementById('title-input').value || 'Nama kursus...';
  var level = document.getElementById('level-input').value;
  var type = document.getElementById('type-input').value;
  var popular = document.getElementById('popular-input').checked;

  document.getElementById('icon-preview').textContent = icon;
  document.getElementById('preview-icon').textContent = icon;
  document.getElementById('preview-title').textContent = title;
  document.getElementById('preview-level').textContent = level;
  document.getElementById('preview-type').textContent = type;
  document.getElementById('preview-popular').style.display = popular ? 'inline-block' : 'none';
}
</script>
@endpush
