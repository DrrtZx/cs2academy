@php
$isEdit = $mode === 'edit';
$totalModules = $course->modules()->count();
$position = $isEdit
    ? $course->modules()->where('urutan', '<', $module->urutan)->count() + 1
    : $totalModules + 1;
$formAction = $isEdit
    ? route('admin.modules.update', $module)
    : route('admin.modules.store', $course);
$pageTitle = $isEdit ? 'Edit Modul: ' . $module->title : 'Tambah Modul Baru';
$crumbTitle = $isEdit ? 'Edit: ' . \Illuminate\Support\Str::limit($module->title, 35) : 'Tambah Modul Baru';
$existingQuizzes = $isEdit ? $module->quizzes->map(fn($q) => [
    'id' => $q->id, 'pertanyaan' => $q->pertanyaan, 'opsi' => $q->opsi,
    'jawaban_benar' => $q->jawaban_benar, 'penjelasan' => $q->penjelasan,
])->values() : [];
@endphp

@extends('layouts.app')
@section('title', $pageTitle)

@push('styles')
<style>
.wrap { max-width: 840px; margin: 0 auto 60px; padding: 2rem; }
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
.btn-icon { background: var(--bg3); border: 1px solid var(--border); color: var(--text2); width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; font-family: inherit; font-size: 13px; transition: all .15s; }
.btn-icon:hover { color: var(--text); border-color: var(--purple); }
.btn-icon.danger:hover { color: var(--red); border-color: var(--red); }

.section { background: var(--bg2); border: 1px solid var(--border); border-radius: 16px; padding: 24px 26px; margin-bottom: 20px; }
.section-title { font-size: 12px; font-weight: 700; color: var(--text2); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }

.field { margin-bottom: 18px; }
.field:last-child { margin-bottom: 0; }
.field label { display: block; font-size: 12px; font-weight: 700; color: var(--text2); text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 8px; }
.field input[type=text], .field input[type=url], .field textarea, .field select {
  width: 100%; background: var(--bg3); border: 1px solid var(--border); border-radius: 10px;
  padding: 12px 14px; color: var(--text); font-size: 14px; font-family: inherit;
}
.field input:focus, .field textarea:focus, .field select:focus { outline: none; border-color: var(--purple); }
.field textarea { resize: vertical; min-height: 70px; }
.field-hint { font-size: 11.5px; color: var(--text3); margin-top: 6px; }

.field-youtube { position: relative; }
.field-youtube .input-icon-wrap { position: relative; }
.field-youtube input { padding-left: 38px; }
.field-youtube .yt-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--red); font-size: 15px; }
.yt-preview { margin-top: 12px; border-radius: 10px; overflow: hidden; aspect-ratio: 16/9; background: #000; border: 1px solid var(--border); display: none; max-width: 360px; }
.yt-preview.show { display: block; }
.yt-preview iframe { width: 100%; height: 100%; border: 0; }

.dynamic-list { display: flex; flex-direction: column; gap: 8px; margin-bottom: 10px; }
.dynamic-row { display: flex; gap: 8px; align-items: center; }
.dynamic-row input { flex: 1; }
.add-row-btn { background: none; border: 1px dashed var(--border); color: var(--text2); border-radius: 10px; padding: 11px; font-size: 13px; cursor: pointer; width: 100%; text-align: center; font-family: inherit; transition: all .15s; }
.add-row-btn:hover { border-color: var(--purple); color: var(--text); }

/* Quiz Accordion */
.quiz-header-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
.quiz-count-badge { font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 999px; background: rgba(139,123,255,0.15); color: var(--purple2); }

.quiz-accordion { display: flex; flex-direction: column; gap: 10px; }
.quiz-item { background: var(--bg3); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
.quiz-item-head { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; cursor: pointer; }
.quiz-item-head:hover { background: rgba(255,255,255,0.02); }
.quiz-item-head-left { display: flex; align-items: center; gap: 10px; min-width: 0; flex: 1; }
.quiz-num { width: 26px; height: 26px; border-radius: 8px; background: var(--bg4); color: var(--text2); font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.quiz-preview-text { font-size: 13.5px; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.quiz-chevron { color: var(--text3); font-size: 12px; transition: transform 0.2s ease; flex-shrink: 0; }
.quiz-item.open .quiz-chevron { transform: rotate(180deg); }
.quiz-item-head-actions { display: flex; gap: 6px; flex-shrink: 0; }

.quiz-item-body { display: none; padding: 0 16px 18px; border-top: 1px solid var(--border); }
.quiz-item.open .quiz-item-body { display: block; padding-top: 16px; }

.quiz-opt-row { display: flex; align-items: center; gap: 10px; margin-bottom: 9px; }
.quiz-opt-row input[type=radio] { accent-color: var(--green); flex-shrink: 0; width: 16px; height: 16px; cursor: pointer; }
.quiz-opt-row input[type=text] { flex: 1; }
.quiz-opt-letter { font-size: 12px; font-weight: 700; color: var(--text3); width: 16px; flex-shrink: 0; }
.quiz-opt-hint { font-size: 11px; color: var(--text3); margin: 4px 0 14px; display: flex; align-items: center; gap: 5px; }

.empty-quiz { text-align: center; padding: 30px 10px; color: var(--text3); font-size: 13.5px; display: none; }

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
    <a href="{{ route('admin.courses') }}">Kelola Kursus</a> ›
    <a href="{{ route('admin.courses.modules', $course) }}">{{ $course->title }}</a> ›
    <b>{{ $crumbTitle }}</b>
  </div>

  <div class="page-head">
    <div>
      <h1 class="page-title">{{ $pageTitle }}</h1>
      <p class="page-sub">
        @if($isEdit)
          Modul {{ $position }} dari {{ $totalModules }} di kursus "{{ $course->title }}"
        @else
          Modul {{ $position }} di kursus "{{ $course->title }}"
        @endif
      </p>
    </div>
    <a href="{{ route('admin.courses.modules', $course) }}" class="btn btn-ghost btn-sm">← Kembali ke List Modul</a>
  </div>

  <form method="POST" action="{{ $formAction }}" id="module-form" onsubmit="return onFormSubmit()">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <input type="hidden" name="body" id="hidden-body" value="{{ old('body', $isEdit ? $module->body : '') }}">

    {{-- ═══ INFO DASAR MODUL ═══ --}}
    <div class="section">
      <div class="section-title">📝 Info Dasar Modul</div>

      <div class="field">
        <label>Nama Modul</label>
        <input type="text" name="title" id="mod-title"
               value="{{ old('title', $isEdit ? $module->title : '') }}"
               placeholder="Contoh: Counter-Strafing" required>
      </div>

      <div class="field field-youtube">
        <label>Link Video YouTube (opsional)</label>
        <div class="input-icon-wrap">
          <span class="yt-icon">▶</span>
          <input type="url" name="youtube_url" id="yt-input"
                 value="{{ old('youtube_url', $isEdit ? $module->youtube_url : '') }}"
                 placeholder="https://www.youtube.com/watch?v=..."
                 oninput="previewYoutube(this.value)">
        </div>
        <div class="field-hint">Kosongkan kalau modul ini tidak ada video, cukup materi teks + quiz.</div>
        <div class="yt-preview{{ old('youtube_url', $isEdit && $module->youtube_url ? ' show' : '') }}" id="yt-preview">
          <iframe id="yt-frame" src="{{ old('youtube_url', $isEdit && $module->youtube_url ? $module->youtube_embed_url : '') }}" title="preview"></iframe>
        </div>
      </div>

      <div class="field">
        <label>Outline / Poin Materi</label>
        <div class="dynamic-list" id="outline-list">
          @php
            $bodyVal = old('body') ?: ($isEdit && $module->body ? $module->body : '');
            $outlineLines = $bodyVal ? explode("\n", $bodyVal) : [''];
          @endphp
          @foreach($outlineLines as $line)
          <div class="dynamic-row">
            <input type="text" value="{{ $line }}" placeholder="Poin materi...">
            <button type="button" class="btn-icon danger" onclick="this.parentElement.remove()">✕</button>
          </div>
          @endforeach
        </div>
        <button type="button" class="add-row-btn" onclick="addOutlineRow()">+ Tambah Poin Materi</button>
      </div>
    </div>

    {{-- ═══ SOAL QUIZ ACCORDION ═══ --}}
    <div class="section">
      <div class="quiz-header-row">
        <div class="section-title" style="margin-bottom:0;">🎯 Soal Quiz Modul Ini <span class="quiz-count-badge" id="quiz-count">0 soal</span></div>
      </div>

      <div class="quiz-accordion" id="quiz-accordion"></div>
      <div class="empty-quiz" id="empty-quiz">Belum ada soal quiz. Klik "+ Tambah Soal Quiz" di bawah.</div>

      <button type="button" class="add-row-btn" style="margin-top:12px;" onclick="addQuizItem()">+ Tambah Soal Quiz</button>
    </div>

    <div class="sticky-footer">
      <a href="{{ route('admin.courses.modules', $course) }}" class="btn btn-ghost">Batal</a>
      <button type="submit" class="btn btn-primary">💾 Simpan Modul</button>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
// ── YouTube preview ──
function extractYoutubeId(url) {
  var m = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/|youtube\.com\/shorts\/)([\w-]{11})/);
  return m ? m[1] : null;
}
function previewYoutube(url) {
  var id = extractYoutubeId(url);
  var box = document.getElementById('yt-preview');
  var frame = document.getElementById('yt-frame');
  if (id) { frame.src = 'https://www.youtube.com/embed/' + id; box.classList.add('show'); }
  else { box.classList.remove('show'); frame.src = ''; }
}

// ── Outline ──
function addOutlineRow() {
  var wrap = document.getElementById('outline-list');
  var row = document.createElement('div');
  row.className = 'dynamic-row';
  row.innerHTML = '<input type="text" placeholder="Poin materi baru..."><button type="button" class="btn-icon danger" onclick="this.parentElement.remove()">✕</button>';
  wrap.appendChild(row);
}

function onFormSubmit() {
  var rows = document.querySelectorAll('#outline-list .dynamic-row input');
  var lines = [];
  rows.forEach(function(r) { var v = r.value.trim(); if (v) lines.push(v); });
  document.getElementById('hidden-body').value = lines.join('\n');
  return true;
}

// ── Quiz Accordion ──
var quizCounter = 0;

function escHtml(s) { return String(s).replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

function renderQuizItem(data) {
  quizCounter++;
  var id = quizCounter;
  var qId = (data && data.id) ? data.id : '';
  var pertanyaan = (data && data.pertanyaan) ? data.pertanyaan : '';
  var opsi = (data && data.opsi) ? data.opsi : ['','','',''];
  var jawaban = (data && data.jawaban_benar !== undefined) ? data.jawaban_benar : 0;
  var penjelasan = (data && data.penjelasan) ? data.penjelasan : '';

  var item = document.createElement('div');
  item.className = 'quiz-item';
  item.id = 'quiz-item-' + id;

  var h = '';
  h += '<input type="hidden" name="quizzes[' + (id-1) + '][id]" value="' + qId + '">';
  h += '<div class="quiz-item-head" onclick="toggleQuiz(' + id + ')">';
  h += '<div class="quiz-item-head-left"><div class="quiz-num">' + id + '</div>';
  h += '<div class="quiz-preview-text" id="preview-' + id + '">' + escHtml(pertanyaan || 'Pertanyaan baru...') + '</div></div>';
  h += '<div class="quiz-item-head-actions">';
  h += '<button type="button" class="btn-icon danger" onclick="event.stopPropagation(); removeQuizItem(' + id + ')">✕</button>';
  h += '<span class="quiz-chevron">▾</span></div></div>';
  h += '<div class="quiz-item-body">';
  h += '<div class="field"><label>Pertanyaan</label>';
  h += '<textarea name="quizzes[' + (id-1) + '][pertanyaan]" oninput="updatePreview(' + id + ', this.value)" placeholder="Tulis pertanyaan kuis di sini..." required>' + escHtml(pertanyaan) + '</textarea></div>';
  ['A','B','C','D'].forEach(function(l, idx) {
    h += '<div class="quiz-opt-row"><span class="quiz-opt-letter">' + l + '</span>';
    h += '<input type="radio" name="quizzes[' + (id-1) + '][jawaban_benar]" value="' + idx + '" ' + (idx === jawaban ? 'checked' : '') + '>';
    h += '<input type="text" name="quizzes[' + (id-1) + '][opsi][' + idx + ']" value="' + escHtml(opsi[idx] || '') + '" placeholder="Pilihan ' + l + '" required></div>';
  });
  h += '<div class="quiz-opt-hint">✅ Centang radio button di jawaban yang benar</div>';
  h += '<div class="field" style="margin-bottom:0;"><label>Penjelasan (opsional)</label>';
  h += '<textarea name="quizzes[' + (id-1) + '][penjelasan]" placeholder="Jelaskan kenapa jawaban itu benar...">' + escHtml(penjelasan) + '</textarea></div></div>';

  item.innerHTML = h;
  return item;
}

function addQuizItem(open) {
  if (open === undefined) open = true;
  document.getElementById('quiz-accordion').appendChild(renderQuizItem({}));
  updateQuizCount();
  if (open) toggleQuiz(quizCounter);
}

function removeQuizItem(id) {
  var el = document.getElementById('quiz-item-' + id);
  if (el) el.remove();
  updateQuizCount();
}

function toggleQuiz(id) {
  document.getElementById('quiz-item-' + id).classList.toggle('open');
}

function updatePreview(id, val) {
  var el = document.getElementById('preview-' + id);
  if (el) el.textContent = val || 'Pertanyaan baru...';
}

function updateQuizCount() {
  var count = document.querySelectorAll('#quiz-accordion .quiz-item').length;
  document.getElementById('quiz-count').textContent = count + ' soal';
  document.getElementById('empty-quiz').style.display = count === 0 ? 'block' : 'none';
}

// ── Load existing quizzes ──
var existingQuizzes = {{ Js::from($existingQuizzes) }};
existingQuizzes.forEach(function(q) {
  document.getElementById('quiz-accordion').appendChild(renderQuizItem({
    id: q.id, pertanyaan: q.pertanyaan, opsi: q.opsi,
    jawaban_benar: q.jawaban_benar, penjelasan: q.penjelasan
  }));
});
updateQuizCount();
if (!existingQuizzes.length) document.getElementById('empty-quiz').style.display = 'block';
</script>
@endpush
