@extends('layouts.app')
@section('title', 'Admin — Kelola Quiz')

@push('styles')
<style>
.admin-wrap{max-width:1000px;margin:0 auto;padding:3rem 2rem;}
.admin-tabs{display:flex;gap:8px;margin-bottom:2rem;flex-wrap:wrap;}
.admin-tab{padding:9px 20px;border-radius:9px;border:1px solid var(--border);background:var(--bg2);color:var(--text2);font-size:0.85rem;font-weight:600;cursor:pointer;transition:all .2s;text-decoration:none;}
.admin-tab:hover,.admin-tab.active{background:var(--grad-primary);border-color:transparent;color:#fff;}
.course-block{background:var(--bg2);border:1px solid var(--border);border-radius:14px;margin-bottom:1.5rem;overflow:hidden;}
.course-header{display:flex;justify-content:space-between;align-items:center;padding:1.2rem 1.5rem;background:linear-gradient(135deg,var(--bg3),var(--bg4));border-bottom:1px solid var(--border);cursor:pointer;}
.course-header h3{font-size:1rem;font-weight:700;}
.course-body-inner{padding:1.5rem;}
.quiz-card{background:var(--bg3);border:1px solid var(--border);border-radius:11px;padding:1.25rem;margin-bottom:1rem;}
.quiz-card-head{display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;margin-bottom:1rem;}
.f-inp{width:100%;background:var(--bg);border:1.5px solid var(--border);color:var(--text);padding:9px 12px;border-radius:9px;font-size:0.875rem;outline:none;transition:border-color .2s;}
.f-inp:focus{border-color:var(--purple);}
.f-inp.f-err{border-color:var(--red);}
.opt-row{display:grid;grid-template-columns:auto 1fr auto;gap:8px;align-items:center;margin-bottom:6px;}
.opt-label{font-size:0.78rem;font-weight:700;color:var(--text3);width:22px;text-align:center;}
.correct-check{width:18px;height:18px;accent-color:var(--green);cursor:pointer;}
.save-btn{background:var(--green);color:#13141a;border:none;padding:8px 18px;border-radius:8px;font-size:0.82rem;font-weight:700;cursor:pointer;}
.save-btn:hover{opacity:0.9;}
.del-btn{background:rgba(255,107,107,0.1);color:var(--red);border:1px solid rgba(255,107,107,0.25);padding:5px 11px;border-radius:7px;font-size:0.75rem;font-weight:700;cursor:pointer;}
.del-btn:hover{background:rgba(255,107,107,0.2);}
.add-quiz-btn{width:100%;padding:10px;border-radius:9px;border:1px dashed var(--purple);background:rgba(124,111,224,0.06);color:var(--purple2);font-size:0.85rem;font-weight:600;cursor:pointer;transition:all .2s;margin-top:0.5rem;}
.add-quiz-btn:hover{background:rgba(124,111,224,0.12);}
.hint-text{font-size:0.7rem;color:var(--text3);margin-top:3px;}
.field-error{font-size:0.72rem;color:var(--red);margin-top:3px;}
.yt-icon{color:#ff0000;}
.yt-preview{margin-top:8px;border-radius:8px;overflow:hidden;border:1px solid var(--border);max-width:280px;}
.yt-preview img{width:100%;display:block;}
</style>
@endpush

@section('content')
<div class="admin-wrap">
  <div style="margin-bottom:1.5rem;">
    <h2 style="font-size:1.5rem;font-weight:800;display:flex;align-items:center;gap:10px;"><x-cs-icon name="settings" size="20" stroke="2" /> Admin Panel</h2>
    <p style="color:var(--text2);font-size:0.875rem;">Kelola tugas user dan konten quiz kursus</p>
  </div>

  <div class="admin-tabs">
    <a href="{{ route('admin.dashboard') }}" class="admin-tab" style="display:inline-flex;align-items:center;gap:7px;"><x-cs-icon name="bar-chart" size="14" stroke="2" /> Dashboard</a>
    <a href="{{ route('admin.assignments') }}" class="admin-tab" style="display:inline-flex;align-items:center;gap:7px;"><x-cs-icon name="clipboard-list" size="14" stroke="2" /> Tugas User</a>
    <a href="{{ route('admin.quiz') }}" class="admin-tab active" style="display:inline-flex;align-items:center;gap:7px;"><x-cs-icon name="lightbulb" size="14" stroke="2" /> Kelola Quiz</a>
  </div>

  @foreach($courses as $course)
  <div class="course-block">
    <div class="course-header" onclick="toggleCourse({{ $course->id }})">
      <h3>{{ $course->icon }} {{ $course->title }}</h3>
      <span style="color:var(--text3);font-size:0.85rem;" id="arrow-{{ $course->id }}">▼ {{ $course->quizzes->count() }} soal</span>
    </div>
    <div class="course-body-inner" id="cb-{{ $course->id }}">

      @foreach($course->quizzes as $quiz)
      <div class="quiz-card" id="qc-{{ $quiz->id }}">
        <div class="quiz-card-head">
          <span style="font-size:0.72rem;color:var(--text3);font-weight:700;">SOAL #{{ $loop->iteration }}</span>
          <form method="POST" action="{{ route('admin.quiz.delete', $quiz) }}" onsubmit="return confirm('Hapus soal ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="del-btn" style="display:inline-flex;align-items:center;gap:5px;">
                <x-cs-icon name="trash" size="13" stroke="2" /> Hapus
            </button>
          </form>
        </div>

        <form method="POST" action="{{ route('admin.quiz.update', $quiz) }}">
          @csrf @method('PUT')

          <div style="margin-bottom:0.75rem;">
            <div style="font-size:0.7rem;color:var(--text2);font-weight:700;text-transform:uppercase;margin-bottom:4px;">Pertanyaan:</div>
            <input type="text" name="pertanyaan" class="f-inp" value="{{ $quiz->pertanyaan }}" required>
          </div>

          <div style="margin-bottom:0.75rem;">
            <div style="font-size:0.7rem;color:var(--text2);font-weight:700;text-transform:uppercase;margin-bottom:6px;">Pilihan Jawaban <span style="color:var(--green);font-weight:600;">(✓ = jawaban benar)</span>:</div>
            @foreach(['a','b','c','d'] as $i => $opt)
            <div class="opt-row">
              <span class="opt-label">{{ strtoupper($opt) }}</span>
              <input type="text" name="opsi[]" class="f-inp" value="{{ $quiz->opsi[$i] ?? '' }}" required>
              <input type="radio" name="jawaban_benar" value="{{ $i }}" class="correct-check" {{ $quiz->jawaban_benar == $i ? 'checked':'' }}>
            </div>
            @endforeach
            <p class="hint-text">Klik lingkaran ✓ di sebelah kanan untuk menandai jawaban yang benar.</p>
          </div>

          <div style="margin-bottom:0.75rem;">
            <div style="font-size:0.7rem;color:var(--text2);font-weight:700;text-transform:uppercase;margin-bottom:4px;">Penjelasan:</div>
            <input type="text" name="penjelasan" class="f-inp" value="{{ $quiz->penjelasan }}" placeholder="Opsional — penjelasan jawaban benar">
          </div>

          {{-- ═══ FIELD YOUTUBE URL ═══ --}}
          <div style="margin-bottom:0.75rem;">
            <div style="font-size:0.7rem;color:var(--text2);font-weight:700;text-transform:uppercase;margin-bottom:4px;">
              <span class="yt-icon">▶</span> Link Video YouTube (Unlisted):
            </div>
            <input
              type="text"
              name="youtube_url"
              class="f-inp"
              value="{{ $quiz->youtube_url }}"
              placeholder="https://youtube.com/watch?v=xxxxxxxxxxx atau https://youtu.be/xxxxxxxxxxx"
            >
            <p class="hint-text">Opsional. Tempel link YouTube unlisted, sistem otomatis ekstrak Video ID dan tampilkan player.</p>

            @if($quiz->youtube_video_id)
              <div class="yt-preview">
                <img src="https://img.youtube.com/vi/{{ $quiz->youtube_video_id }}/mqdefault.jpg" alt="Preview video">
              </div>
              <p class="hint-text" style="color:var(--green);">✓ Video terdeteksi (ID: {{ $quiz->youtube_video_id }})</p>
            @endif
          </div>

          <button type="submit" class="save-btn" style="display:inline-flex;align-items:center;gap:6px;">
              <x-cs-icon name="save" size="14" stroke="2" /> Simpan Perubahan
          </button>
        </form>
      </div>
      @endforeach

      {{-- Form Tambah Soal Baru --}}
      <div id="add-form-{{ $course->id }}" style="display:none;background:var(--bg3);border:1px solid rgba(124,111,224,0.3);border-radius:11px;padding:1.25rem;margin-bottom:0.5rem;">
        <div style="font-size:0.85rem;font-weight:700;margin-bottom:1rem;color:var(--purple2);display:flex;align-items:center;gap:7px;">
            <x-cs-icon name="plus" size="14" stroke="2.5" /> Tambah Soal Baru
        </div>
        <form method="POST" action="{{ route('admin.quiz.store', $course) }}">
          @csrf

          <div style="margin-bottom:0.75rem;">
            <div style="font-size:0.7rem;color:var(--text2);font-weight:700;text-transform:uppercase;margin-bottom:4px;">Pertanyaan:</div>
            <input type="text" name="pertanyaan" class="f-inp" placeholder="Tulis pertanyaan di sini..." required>
          </div>

          <div style="margin-bottom:0.75rem;">
            <div style="font-size:0.7rem;color:var(--text2);font-weight:700;text-transform:uppercase;margin-bottom:6px;">Pilihan Jawaban <span style="color:var(--green);">(✓ = benar)</span>:</div>
            @foreach(['A','B','C','D'] as $i => $opt)
            <div class="opt-row">
              <span class="opt-label">{{ $opt }}</span>
              <input type="text" name="opsi[]" class="f-inp" placeholder="Pilihan {{ $opt }}" required>
              <input type="radio" name="jawaban_benar" value="{{ $i }}" class="correct-check" {{ $i===0?'checked':'' }}>
            </div>
            @endforeach
          </div>

          <div style="margin-bottom:0.75rem;">
            <div style="font-size:0.7rem;color:var(--text2);font-weight:700;text-transform:uppercase;margin-bottom:4px;">Penjelasan:</div>
            <input type="text" name="penjelasan" class="f-inp" placeholder="Penjelasan jawaban benar (opsional)">
          </div>

          {{-- ═══ FIELD YOUTUBE URL (FORM TAMBAH) ═══ --}}
          <div style="margin-bottom:0.75rem;">
            <div style="font-size:0.7rem;color:var(--text2);font-weight:700;text-transform:uppercase;margin-bottom:4px;">
              <span class="yt-icon">▶</span> Link Video YouTube (Unlisted):
            </div>
            <input
              type="text"
              name="youtube_url"
              class="f-inp"
              placeholder="https://youtube.com/watch?v=xxxxxxxxxxx atau https://youtu.be/xxxxxxxxxxx"
            >
            <p class="hint-text">Opsional. Bisa diisi nanti lewat menu Edit.</p>
          </div>

          <div style="display:flex;gap:8px;">
            <button type="submit" class="save-btn" style="display:inline-flex;align-items:center;gap:6px;">
                <x-cs-icon name="check" size="14" stroke="2.5" /> Tambah Soal
            </button>
            <button type="button" onclick="document.getElementById('add-form-{{ $course->id }}').style.display='none';document.getElementById('show-add-{{ $course->id }}').style.display='block';" class="del-btn">Batal</button>
          </div>
        </form>
      </div>

      <button class="add-quiz-btn" id="show-add-{{ $course->id }}" onclick="document.getElementById('add-form-{{ $course->id }}').style.display='block';this.style.display='none';" style="display:flex;align-items:center;justify-content:center;gap:7px;">
        <x-cs-icon name="plus" size="14" stroke="2.5" /> Tambah Soal Baru untuk &ldquo;{{ $course->title }}&rdquo;
      </button>
    </div>
  </div>
  @endforeach
</div>
@endsection

@push('scripts')
<script>
function toggleCourse(id) {
  const el = document.getElementById('cb-'+id);
  const ar = document.getElementById('arrow-'+id);
  if (el.style.display === 'none') {
    el.style.display = 'block';
    ar.textContent = ar.textContent.replace('▶','▼');
  } else {
    el.style.display = 'none';
    ar.textContent = ar.textContent.replace('▼','▶');
  }
}
</script>
@endpush
