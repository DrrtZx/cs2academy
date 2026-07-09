@extends('layouts.app')
@section('title', 'Courses')

@push('styles')
<style>
.lms-layout{display:grid;grid-template-columns:270px 1fr;gap:1.75rem;max-width:1200px;margin:0 auto;padding:3rem 2rem;}
.lms-sidebar{background:var(--bg2);border:1px solid var(--border);border-radius:15px;padding:1.4rem;height:fit-content;position:sticky;top:80px;}
.sidebar-title{font-size:0.7rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:1rem;}
.cli{display:flex;align-items:center;gap:9px;padding:9px 11px;border-radius:9px;cursor:pointer;transition:all .2s;margin-bottom:3px;border:none;background:none;width:100%;text-align:left;color:var(--text);}
.cli:hover{background:var(--bg3);}
.cli.active{background:rgba(124,111,224,0.13);border:1px solid rgba(124,111,224,0.25);}
.cli-ic{font-size:1rem;width:28px;text-align:center;}
.cli-n{font-size:0.84rem;font-weight:600;flex:1;}
.cli-st{font-size:0.68rem;padding:2px 7px;border-radius:50px;font-weight:600;}
.st-done{background:rgba(0,212,170,0.15);color:var(--green);}
.st-lock{background:rgba(102,102,170,0.1);color:var(--text3);}
.st-act{background:rgba(124,111,224,0.2);color:var(--purple2);}
.prog-bar{background:var(--bg4);border-radius:50px;height:6px;overflow:hidden;margin:0.6rem 0 0.4rem;}
.prog-fill{height:100%;background:var(--green);border-radius:50px;transition:width .5s;}
.lms-main{background:var(--bg2);border:1px solid var(--border);border-radius:15px;overflow:hidden;}
.cv{height:200px;background:var(--bg3);display:flex;align-items:center;justify-content:center;font-size:3.5rem;position:relative;}
.cv-play{position:absolute;width:56px;height:56px;background:rgba(108,92,231,0.9);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.3rem;cursor:pointer;transition:transform .2s;}
.cv-play:hover{transform:scale(1.1);}
.course-body{padding:1.75rem;}
.quiz-box{background:var(--bg3);border:1px solid var(--border);border-radius:13px;padding:1.5rem;}
.quiz-hd{display:flex;align-items:center;gap:8px;margin-bottom:1rem;}
.qz-badge{background:rgba(255,140,66,0.2);color:var(--orange);font-size:0.7rem;font-weight:700;padding:2px 9px;border-radius:50px;}
.qz-prog{display:flex;gap:5px;margin-bottom:1rem;}
.qz-dot{width:9px;height:9px;border-radius:50%;background:var(--bg4);}
.qz-dot.done{background:var(--green);}
.qz-dot.cur{background:var(--purple-btn);}
.qz-q{font-size:0.95rem;font-weight:700;margin-bottom:1rem;line-height:1.5;color:var(--text);}
.qz-opts{display:flex;flex-direction:column;gap:7px;margin-bottom:1rem;}
.qz-opt{padding:11px 14px;border-radius:9px;border:1.5px solid var(--border);cursor:pointer;font-size:0.85rem;transition:all .2s;background:var(--bg);text-align:left;color:var(--text);}
.qz-opt:hover:not(.dis){border-color:var(--purple);background:rgba(124,111,224,0.07);color:var(--text);}
.qz-opt.cor{border-color:var(--green);background:rgba(0,212,170,0.1);color:var(--green);}
.qz-opt.wrn{border-color:var(--red);background:rgba(255,107,107,0.1);color:var(--red);}
.qz-opt.dis{cursor:default;color:var(--text2);}
.qz-fb{padding:11px 14px;border-radius:9px;font-size:0.84rem;margin-bottom:0.9rem;display:none;color:var(--text);}
.qz-fb.show{display:block;}
.qz-fb.cor{background:rgba(0,212,170,0.1);border:1px solid rgba(0,212,170,0.3);color:var(--green);}
.qz-fb.wrn{background:rgba(255,107,107,0.1);border:1px solid rgba(255,107,107,0.3);color:var(--red);}
.qz-nxt{background:var(--grad-primary);color:#fff;border:none;padding:9px 22px;border-radius:9px;font-size:0.85rem;font-weight:700;cursor:pointer;display:none;box-shadow:0 8px 18px -9px rgba(139,123,255,.7);}
.qz-nxt.show{display:inline-block;}
.cnav{display:flex;gap:8px;margin-top:1.4rem;}
.cn-btn{flex:1;padding:10px;border-radius:9px;font-size:0.85rem;font-weight:700;cursor:pointer;transition:all .2s;border:1px solid var(--border);background:var(--bg3);color:var(--text);}
.cn-btn:hover{border-color:var(--purple);color:var(--purple2);}
.cn-btn.pri{background:var(--grad-primary);border-color:transparent;color:#fff;}
.cn-btn.pri:hover{filter:brightness(1.08);}

/* ── YOUTUBE RESPONSIVE EMBED ── */
.yt-wrapper{position:relative;width:100%;padding-top:56.25%;background:#000;border-radius:10px;overflow:hidden;margin-bottom:1.4rem;}
.yt-wrapper iframe{position:absolute;top:0;left:0;width:100%;height:100%;border:0;}
</style>
@endpush

@section('content')

{{-- Popup lock untuk guest --}}
@guest
<div class="modal-overlay" id="courseModal" style="z-index:501;">
  <div class="modal-box" style="position:relative;max-width:400px;">
    <button class="modal-close" onclick="document.getElementById('courseModal').classList.remove('open');document.body.style.overflow='';" style="display:flex;align-items:center;justify-content:center;">
        <x-cs-icon name="x" size="16" />
    </button>
    <div class="modal-head" style="text-align:center;">
      <div style="display:flex;align-items:center;justify-content:center;margin-bottom:0.75rem;">
        <span style="display:inline-flex;align-items:center;justify-content:center;width:52px;height:52px;border-radius:50%;background:rgba(139,123,255,0.12);border:1px solid rgba(139,123,255,0.25);">
            <x-cs-icon name="lock" size="22" stroke="1.75" style="color:var(--purple2)" />
        </span>
      </div>
      <div class="modal-logo"><x-cs-logo size="18" /></div>
      <h3 style="font-size:1.2rem;font-weight:800;margin-bottom:0.3rem;">Akses Terkunci</h3>
      <p style="font-size:0.82rem;color:var(--text2);">Login atau daftar gratis untuk mengakses seluruh materi kursus CS2.</p>
    </div>
    <div style="padding:1.5rem 1.75rem;display:flex;flex-direction:column;gap:10px;">
      <button class="btn-full" onclick="document.getElementById('courseModal').classList.remove('open');openModal('login');">Masuk ke Akun</button>
      <button onclick="document.getElementById('courseModal').classList.remove('open');openModal('register');" style="width:100%;padding:11px;border-radius:10px;border:1px solid var(--border);background:transparent;color:var(--text);font-size:0.9rem;font-weight:600;cursor:pointer;">Daftar Gratis &rarr;</button>
    </div>
    <div style="text-align:center;padding:0 1.75rem 1.25rem;font-size:0.78rem;color:var(--text3);">&#10003; Gratis &middot; &#10003; Tanpa kartu kredit &middot; &#10003; Akses instan</div>
  </div>
</div>
@endguest

<div class="lms-layout">
  {{-- Sidebar --}}
  <div class="lms-sidebar">
    <div class="sidebar-title">Daftar Kursus</div>
    @foreach($courses as $i => $course)
    <button class="cli {{ $i === 0 ? 'active' : '' }}" id="cli-{{ $i }}" onclick="selCourse({{ $i }})">
      <span class="cli-ic">{{ $course->icon }}</span>
      <span class="cli-n">{{ $course->title }}</span>
      <span class="cli-st {{ $i === 0 ? 'st-act' : 'st-lock' }}" id="cst-{{ $i }}">
        @if($i === 0)
          Aktif
        @else
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        @endif
      </span>
    </button>
    @endforeach
    <div style="margin-top:1.4rem;padding-top:1.1rem;border-top:1px solid var(--border);">
      <div class="sidebar-title">Progress Kamu</div>
      <div class="prog-bar"><div class="prog-fill" id="prog-fill" style="width:0%"></div></div>
      <div style="font-size:.72rem;color:var(--text2);">
        <span id="prog-txt">0</span> dari {{ $courses->count() }} kursus selesai
      </div>
    </div>
  </div>
  {{-- Main Content --}}
  <div class="lms-main" id="lms-main"></div>
</div>
@endsection

@push('scripts')
<script>
const COURSES = {!! $coursesJson !!};
const TOTAL = COURSES.length;
const COMPLETED_COURSE_IDS = {!! json_encode($completedCourseIds ?? []) !!};
const IS_AUTH = @json(auth()->check());

let curCourse = 0;
// Restore progress dari server (biar gak ke-reset kalau halaman di-refresh)
let completed = new Set(
  COURSES.map((c, i) => i).filter(i => COMPLETED_COURSE_IDS.includes(COURSES[i].id))
);
let qState = {};

@guest
document.addEventListener('DOMContentLoaded', function() {
  openCourseModal();
});
@endguest

// Buka kembali modal login/daftar. Dipakai saat guest mencoba berinteraksi
// dengan quiz/kursus setelah sebelumnya menutup modal via tombol ✕.
function openCourseModal() {
  var m = document.getElementById('courseModal');
  if (m) { m.classList.add('open'); document.body.style.overflow = 'hidden'; }
}

// Guard utama: kembalikan true kalau boleh lanjut, false kalau guest
// (sekaligus munculkan lagi modal supaya mereka gak bisa diam-diam lanjut
// walau modalnya sudah pernah ditutup dengan ✕).
function requireAuth() {
  if (IS_AUTH) return true;
  openCourseModal();
  return false;
}

function selCourse(idx) {
  if (!requireAuth()) return;
  if (idx > 0 && !completed.has(idx - 1)) {
    alert('Selesaikan kursus sebelumnya dulu! 🔒');
    return;
  }
  curCourse = idx;
  document.querySelectorAll('.cli').forEach((el, i) => el.classList.toggle('active', i === idx));
  renderCourse(idx);
}

function renderCourse(idx) {
  const c = COURSES[idx];
  qState = { q: 0, done: false, score: 0 };

  // Guard: kursus tanpa soal quiz (misal semua soal dihapus admin)
  if (!c.quiz || c.quiz.length === 0) {
    document.getElementById('lms-main').innerHTML = `
      <div class="course-body">
        <div style="font-size:0.7rem;color:var(--text3);margin-bottom:0.4rem;">CS2 Academy › ${c.title}</div>
        <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:0.65rem;">${c.ic} ${c.title}</h2>
        <p style="color:var(--text2);font-size:0.875rem;line-height:1.75;margin-bottom:1.4rem;">${c.body}</p>
        <div class="quiz-box">Belum ada soal quiz untuk kursus ini. Silakan cek lagi nanti. 🙏</div>
        <div class="cnav">
          ${idx > 0 ? `<button class="cn-btn" onclick="selCourse(${idx - 1})">← Sebelumnya</button>` : ''}
        </div>
      </div>`;
    return;
  }

  const q = c.quiz[0];

  const videoBlock = q.video_id
    ? `<div class="yt-wrapper">
         <iframe
           src="https://www.youtube.com/embed/${q.video_id}"
           title="Video pembahasan"
           allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
           allowfullscreen
           loading="lazy">
         </iframe>
       </div>`
    : '';

  document.getElementById('lms-main').innerHTML = `
    </div>
    <div class="course-body">
      <div style="font-size:0.7rem;color:var(--text3);margin-bottom:0.4rem;">CS2 Academy › ${c.title}</div>
      <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:0.65rem;">${c.ic} ${c.title}</h2>
      <p style="color:var(--text2);font-size:0.875rem;line-height:1.75;margin-bottom:1.4rem;">${c.body}</p>
      <div class="quiz-box">
        <div class="quiz-hd">🎯 <strong>Quiz Interaktif</strong> <span class="qz-badge">Quiz</span></div>
        <div class="qz-prog" id="qz-prog">
          ${c.quiz.map((_, i) => `<div class="qz-dot ${i === 0 ? 'cur' : ''}" id="qd-${i}"></div>`).join('')}
        </div>
        ${videoBlock}
        <div class="qz-q" id="qz-q">${q.q}</div>
        <div class="qz-opts" id="qz-opts">
          ${q.opts.map((o, i) => `<button class="qz-opt" id="qo-${i}" onclick="ansQ(${i})">${String.fromCharCode(65 + i)}. ${o}</button>`).join('')}
        </div>
        <div class="qz-fb" id="qz-fb"></div>
        <button class="qz-nxt" id="qz-nxt" onclick="nextQ()">Berikutnya →</button>
      </div>
      <div class="cnav">
        ${idx > 0 ? `<button class="cn-btn" onclick="selCourse(${idx - 1})">← Sebelumnya</button>` : ''}
        <button class="cn-btn pri" id="cn-next" onclick="selCourse(${idx + 1})" style="display:none;">Kursus Berikutnya →</button>
      </div>
    </div>`;

  // Kalau kursus ini sudah pernah lulus sebelumnya (restore state setelah refresh),
  // tandai quiz sebagai selesai & tampilkan tombol lanjut.
  if (completed.has(idx) && idx < TOTAL - 1) {
    document.getElementById('cn-next').style.display = 'block';
  }
}

function ansQ(chosen) {
  if (!requireAuth()) return;
  if (qState.done) return;
  qState.done = true;
  const c = COURSES[curCourse], q = c.quiz[qState.q];
  document.querySelectorAll('.qz-opt').forEach(o => { o.classList.add('dis'); o.onclick = null; });
  const fb = document.getElementById('qz-fb');
  if (chosen === q.ans) {
    document.getElementById('qo-' + chosen).classList.add('cor');
    fb.className = 'qz-fb show cor';
    fb.innerHTML = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:-2px;margin-right:4px;"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg><strong>Benar!</strong> ${q.ex}`;
    qState.score++;
  } else {
    document.getElementById('qo-' + chosen).classList.add('wrn');
    document.getElementById('qo-' + q.ans).classList.add('cor');
    fb.className = 'qz-fb show wrn';
    fb.innerHTML = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:-2px;margin-right:4px;"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg><strong>Salah.</strong> ${q.ex}`;
  }
  const nxt = document.getElementById('qz-nxt');
  nxt.classList.add('show');
  if (qState.q >= c.quiz.length - 1) {
    nxt.textContent = 'Lihat Hasil ✓';
    nxt.onclick = finishQ;
  }
}

function nextQ() {
  if (!requireAuth()) return;
  const c = COURSES[curCourse];
  qState.q++;
  qState.done = false;
  const q = c.quiz[qState.q];

  const lmsMain = document.getElementById('lms-main');
  const existingYt = lmsMain.querySelector('.yt-wrapper');
  if (q.video_id) {
    const newYtHtml = `<div class="yt-wrapper">
         <iframe
           src="https://www.youtube.com/embed/${q.video_id}"
           title="Video pembahasan"
           allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
           allowfullscreen
           loading="lazy">
         </iframe>
       </div>`;
    if (existingYt) {
      existingYt.outerHTML = newYtHtml;
    } else {
      document.getElementById('qz-prog').insertAdjacentHTML('afterend', newYtHtml);
    }
  } else if (existingYt) {
    existingYt.remove();
  }

  document.getElementById('qz-q').textContent = q.q;
  document.getElementById('qz-opts').innerHTML = q.opts.map((o, i) =>
    `<button class="qz-opt" id="qo-${i}" onclick="ansQ(${i})">${String.fromCharCode(65 + i)}. ${o}</button>`
  ).join('');
  document.getElementById('qz-fb').className = 'qz-fb';
  const nxt = document.getElementById('qz-nxt');
  nxt.className = 'qz-nxt';
  nxt.onclick = nextQ;
  document.querySelectorAll('.qz-dot').forEach((d, i) => {
    d.className = 'qz-dot' + (i < qState.q ? ' done' : i === qState.q ? ' cur' : '');
  });
}

function finishQ() {
  if (!requireAuth()) return;
  const c = COURSES[curCourse], total = c.quiz.length, score = qState.score;
  const passed = score >= Math.ceil(total / 2);
  const fb = document.getElementById('qz-fb');
  fb.className = 'qz-fb show ' + (passed ? 'cor' : 'wrn');
  fb.innerHTML = `${passed
    ? '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:-2px;margin-right:4px;"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2z"/></svg>'
    : '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:-2px;margin-right:4px;"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>'} <strong>${passed ? 'Lulus!' : 'Belum Lulus'}</strong> Skor: ${score}/${total}. ${passed ? 'Kursus berikutnya terbuka!' : 'Perlu skor \u2265' + Math.ceil(total / 2) + ' untuk lulus.'}`;
  document.getElementById('qz-nxt').className = 'qz-nxt';
  if (passed) {
    completed.add(curCourse);
    updSidebar();
    updProg();
    if (curCourse < TOTAL - 1) {
      const nb = document.getElementById('cn-next');
      if (nb) nb.style.display = 'block';
    }
    saveProgress(c.id, score);
  }
}

// Simpan progress ke server biar gak hilang saat refresh (hanya untuk user yang login)
function saveProgress(courseId, score) {
  if (!IS_AUTH) return;
  const token = document.querySelector('meta[name="csrf-token"]');
  if (!token) return;
  fetch(`/courses/${courseId}/complete`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': token.getAttribute('content'),
      'Accept': 'application/json',
    },
    body: JSON.stringify({ score }),
  }).catch(() => {
    // Gagal simpan progress ke server tidak boleh mengganggu pengalaman belajar,
    // cukup diabaikan — state tetap benar secara lokal di sesi ini.
  });
}

function updSidebar() {
  COURSES.forEach((_, i) => {
    const st = document.getElementById('cst-' + i);
    if (!st) return;
    if (completed.has(i)) {
      st.className = 'cli-st st-done'; st.textContent = '✓ Selesai';
    } else if (i === 0 || completed.has(i - 1)) {
      st.className = 'cli-st st-act'; st.textContent = 'Aktif';
    } else {
      st.className = 'cli-st st-lock'; st.textContent = '🔒';
    }
  });
}

function updProg() {
  const pct = (completed.size / TOTAL) * 100;
  document.getElementById('prog-fill').style.width = pct + '%';
  document.getElementById('prog-txt').textContent = completed.size;
}

// Inisialisasi awal: restore sidebar & progress bar sesuai data dari server,
// lalu buka kursus pertama yang belum diselesaikan.
updSidebar();
updProg();

let startIdx = COURSES.findIndex((_, i) => !completed.has(i));
if (startIdx === -1) startIdx = TOTAL - 1; // semua kursus sudah selesai

curCourse = startIdx;
document.querySelectorAll('.cli').forEach((el, i) => el.classList.toggle('active', i === startIdx));
renderCourse(startIdx);
</script>
@endpush
