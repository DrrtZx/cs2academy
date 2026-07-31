@extends('layouts.app')
@section('title', $course->title)

@push('styles')
<style>
.wrap { max-width: 1280px; margin: 0 auto; padding: 2.5rem 2rem; }
.breadcrumb { font-size: 13px; color: var(--text3); margin-bottom: 18px; }
.breadcrumb b { color: var(--text2); font-weight: 500; }
.breadcrumb a { color: var(--cyan); text-decoration: none; }

.layout { display: grid; grid-template-columns: 320px 1fr; gap: 24px; align-items: start; }

/* Sidebar */
.sidebar { background: var(--bg2); border: 1px solid var(--border); border-radius: 16px; padding: 20px; }
.sidebar-title { font-size: 11px; letter-spacing: 0.08em; color: var(--text3); text-transform: uppercase; margin-bottom: 14px; font-weight: 600; }
.module-item { display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 12px; cursor: pointer; margin-bottom: 6px; border: 1px solid transparent; transition: background 0.15s ease, border-color 0.15s ease; position: relative; }
.module-item:hover { background: rgba(255,255,255,0.03); }
.module-item.active { background: linear-gradient(135deg, rgba(139,123,255,0.16), rgba(63,216,255,0.10)); border-color: rgba(139,123,255,0.4); }
.module-num { width: 30px; height: 30px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; background: rgba(255,255,255,0.05); color: var(--text2); flex-shrink: 0; }
.module-item.active .module-num { background: var(--grad-primary); color: #fff; }
.module-item.done .module-num { background: rgba(43,230,186,0.15); color: var(--green); }
.module-item.locked .module-num { background: rgba(255,255,255,0.03); color: var(--text3); }
.module-body { flex: 1; min-width: 0; }
.module-name { font-size: 14px; font-weight: 600; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.module-item.locked .module-name { color: var(--text3); }
.module-sub { font-size: 11.5px; color: var(--text3); margin-top: 2px; }

.progress-block { margin-top: 18px; padding-top: 16px; border-top: 1px solid var(--border); }
.progress-label { font-size: 11px; letter-spacing: 0.08em; color: var(--text3); text-transform: uppercase; margin-bottom: 10px; font-weight: 600; }
.progress-bar { height: 6px; background: rgba(255,255,255,0.06); border-radius: 999px; overflow: hidden; margin-bottom: 8px; }
.progress-fill { height: 100%; background: var(--grad-primary); border-radius: 999px; transition: width .5s; }
.progress-text { font-size: 12.5px; color: var(--text2); }

/* Main Panel */
.main { background: var(--bg2); border: 1px solid var(--border); border-radius: 16px; padding: 32px; min-height: 520px; }
.main-header { display: flex; align-items: flex-start; gap: 14px; margin-bottom: 18px; }
.main-icon { width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, rgba(139,123,255,0.25), rgba(63,216,255,0.18)); display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
.main-eyebrow { font-size: 11.5px; color: var(--purple); font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 4px; }
.main-title { font-size: 22px; font-weight: 700; color: var(--text); margin: 0; }

/* YouTube */
.yt-wrapper { position: relative; width: 100%; padding-top: 56.25%; background: #000; border-radius: 10px; overflow: hidden; margin-bottom: 24px; }
.yt-wrapper iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; }

/* Outline */
.outline-box { background: var(--bg3); border: 1px solid var(--border); border-radius: 14px; padding: 20px 22px; margin-bottom: 24px; }
.outline-title { font-size: 12.5px; font-weight: 700; color: var(--text2); letter-spacing: 0.04em; text-transform: uppercase; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }
.outline-list { list-style: none; margin: 0; padding: 0; }
.outline-list li { display: flex; align-items: flex-start; gap: 10px; padding: 9px 0; font-size: 14px; color: var(--text); border-bottom: 1px solid rgba(255,255,255,0.04); }
.outline-list li:last-child { border-bottom: none; }
.outline-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--blue); margin-top: 7px; flex-shrink: 0; }

/* Quiz */
.quiz-box { background: var(--bg3); border: 1px solid var(--border); border-radius: 14px; padding: 22px; }
.quiz-top { display: flex; align-items: center; gap: 10px; margin-bottom: 6px; }
.quiz-badge { font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 999px; background: rgba(255,171,92,0.15); color: var(--orange); }
.quiz-title { font-size: 12.5px; font-weight: 700; color: var(--text2); text-transform: uppercase; letter-spacing: 0.04em; }
.quiz-dots { display: flex; gap: 6px; margin: 14px 0 16px; }
.quiz-dots span { width: 20px; height: 4px; border-radius: 999px; background: rgba(255,255,255,0.08); }
.quiz-dots span.on { background: var(--grad-primary); }
.quiz-question { font-size: 15.5px; font-weight: 600; color: var(--text); margin-bottom: 16px; }
.quiz-options { display: flex; flex-direction: column; gap: 10px; }
.quiz-option { padding: 13px 16px; background: rgba(255,255,255,0.02); border: 1px solid var(--border); border-radius: 10px; font-size: 14px; color: var(--text); cursor: pointer; transition: border-color 0.15s ease, background 0.15s ease; text-align: left; font-family: inherit; }
.quiz-option:hover:not(.dis) { border-color: rgba(139,123,255,0.4); background: rgba(139,123,255,0.06); }
.quiz-option.cor { border-color: var(--green); background: rgba(43,230,186,0.1); color: var(--green); }
.quiz-option.wrn { border-color: var(--red); background: rgba(255,114,114,0.1); color: var(--red); }
.quiz-option.dis { cursor: default; pointer-events: none; }
.quiz-fb { padding: 11px 14px; border-radius: 9px; font-size: 13px; margin-top: 14px; display: none; }
.quiz-fb.show { display: block; }
.quiz-fb.cor { background: rgba(43,230,186,0.1); border: 1px solid rgba(43,230,186,0.3); color: var(--green); }
.quiz-fb.wrn { background: rgba(255,114,114,0.1); border: 1px solid rgba(255,114,114,0.3); color: var(--red); }
.quiz-nxt { background: var(--grad-primary); color: #fff; border: none; padding: 9px 22px; border-radius: 9px; font-size: 0.85rem; font-weight: 700; cursor: pointer; display: none; margin-top: 14px; font-family: inherit; }
.quiz-nxt.show { display: inline-block; }

.qz-prog { display: flex; gap: 5px; margin-bottom: 1rem; }
.qz-dot { width: 9px; height: 9px; border-radius: 50%; background: var(--bg4); }
.qz-dot.done { background: var(--green); }
.qz-dot.cur { background: var(--purple-btn); }

.empty-state { display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 80px 20px; color: var(--text3); }
.empty-emoji { font-size: 36px; margin-bottom: 14px; }
.empty-title { font-size: 16px; font-weight: 600; color: var(--text2); margin-bottom: 6px; }
.empty-sub { font-size: 13.5px; }

</style>
@endpush

@section('content')

@guest
<div class="modal-overlay" id="guestModal">
  <div class="modal-box" style="position:relative;">
    <button class="modal-close" onclick="document.getElementById('guestModal').classList.remove('open');document.body.style.overflow='';">
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
      <button class="btn-full" onclick="document.getElementById('guestModal').classList.remove('open');openModal('login');">Masuk ke Akun</button>
      <button onclick="document.getElementById('guestModal').classList.remove('open');openModal('register');" style="width:100%;padding:11px;border-radius:10px;border:1px solid var(--border);background:transparent;color:var(--text);font-size:0.9rem;font-weight:600;cursor:pointer;">Daftar Gratis &rarr;</button>
    </div>
    <div style="text-align:center;padding:0 1.75rem 1.25rem;font-size:0.78rem;color:var(--text3);">✓ Gratis · ✓ Tanpa kartu kredit · ✓ Akses instan</div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('guestModal').classList.add('open');
  document.body.style.overflow = 'hidden';
});
</script>
@endguest

<div class="wrap">
  <div class="breadcrumb">
    <a href="{{ route('courses') }}">CS2 Academy</a> › <b>{{ $course->title }}</b> <span id="crumb-module"></span>
  </div>

  <div class="layout">
    {{-- SIDEBAR --}}
    <div class="sidebar">
      <div class="sidebar-title">{{ $course->title }} — Modul</div>
      <div id="module-list">
        @foreach($modulesData as $idx => $mod)
        <div class="module-item {{ $mod['status'] }} {{ $mod['id'] === $activeModId ? 'active' : '' }}"
             data-id="{{ $mod['id'] }}" data-status="{{ $mod['status'] }}"
             onclick="selectModule({{ $mod['id'] }})">
          <div class="module-num">
            @if($mod['status'] === 'done')
              <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-7.5 7.5a1 1 0 01-1.4 0l-3.5-3.5a1 1 0 111.4-1.4l2.8 2.8 6.8-6.8a1 1 0 011.4 0z" clip-rule="evenodd"/></svg>
            @elseif($mod['status'] === 'locked')
              <svg width="11" height="11" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 1a4 4 0 00-4 4v2H5a1 1 0 00-1 1v9a1 1 0 001 1h10a1 1 0 001-1V8a1 1 0 00-1-1h-1V5a4 4 0 00-4-4zm2 6V5a2 2 0 10-4 0v2h4z" clip-rule="evenodd"/></svg>
            @else
              {{ $idx + 1 }}
            @endif
          </div>
          <div class="module-body">
            <div class="module-name">{{ $mod['title'] }}</div>
            <div class="module-sub">
              @if($mod['status'] === 'done')
                <span style="display:inline-flex;align-items:center;gap:4px;color:var(--green);font-weight:600;"><x-cs-icon name="check-circle" size="12" stroke="2.5" /> Selesai</span>
              @elseif($mod['status'] === 'locked')
                <span style="display:inline-flex;align-items:center;gap:4px;color:var(--text3);font-weight:500;"><x-cs-icon name="lock" size="11" stroke="2.5" /> Terkunci</span>
              @else
                <span style="display:inline-flex;align-items:center;gap:4px;color:var(--purple2);font-weight:600;"><x-cs-icon name="book-open" size="12" stroke="2.5" /> Baca sekarang</span>
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <div class="progress-block">
        <div class="progress-label">Progress Kamu</div>
        <div class="progress-bar"><div class="progress-fill" id="prog-fill" style="width:{{ $progress }}%"></div></div>
        <div class="progress-text" id="prog-text">
          {{ $modulesData->where('status', 'done')->count() }} dari {{ $modulesData->count() }} modul selesai
        </div>
      </div>
    </div>

    {{-- MAIN PANEL --}}
    <div class="main" id="main-panel"></div>
  </div>
</div>
@endsection

@push('scripts')
<script>
const MODULES = {{ Js::from($modulesData) }};
const COURSE_ID = {{ $course->id }};
const IS_AUTH = @json(auth()->check());
let activeId = {{ $activeModId }};
let quizIndex = 0;        // soal ke-berapa yang sedang aktif
let quizCorrect = {};      // tracking hasil kuis per soal: { "0": true (benar), "1": false (salah) }

@guest
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('guestModal').classList.add('open');
  document.body.style.overflow = 'hidden';
});
@endguest

function requireAuth() {
  if (IS_AUTH) return true;
  document.getElementById('guestModal').classList.add('open');
  document.body.style.overflow = 'hidden';
  return false;
}

function selectModule(id) {
  var m = MODULES.find(function(x) { return x.id === id; });
  if (!m) return;
  if (m.status === 'locked') {
    activeId = id;
    renderSidebar();
    renderMain();
    return;
  }
  activeId = id;
  quizIndex = 0;
  quizCorrect = {};
  renderSidebar();
  renderMain();
}

function renderSidebar() {
  document.querySelectorAll('.module-item').forEach(function(el) {
    var id = parseInt(el.dataset.id);
    var m = MODULES.find(function(x) { return x.id === id; });
    el.className = 'module-item ' + m.status + (id === activeId ? ' active' : '');
  });
}

function renderMain() {
  var m = MODULES.find(function(x) { return x.id === activeId; });
  var panel = document.getElementById('main-panel');
  var crumb = document.getElementById('crumb-module');
  crumb.textContent = ' › ' + m.title;

  if (m.status === 'locked') {
    panel.innerHTML = '<div class="empty-state"><div style="display:inline-flex;align-items:center;justify-content:center;width:60px;height:60px;border-radius:50%;background:rgba(255,140,66,0.12);border:1px solid rgba(255,140,66,0.3);margin-bottom:1rem;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--orange)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div><div class="empty-title">Modul Ini Terkunci</div><div class="empty-sub">Selesaikan modul sebelumnya dulu untuk membuka "' + escHtml(m.title) + '".</div></div>';
    return;
  }

  var done = MODULES.filter(function(x) { return x.status === 'done'; }).length;

  var ytHtml = '';
  if (m.youtube_id) {
    ytHtml = '<div class="yt-wrapper"><iframe src="https://www.youtube.com/embed/' + m.youtube_id + '" title="Video" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe></div>';
  }

  var outlineHtml = '';
  if (m.body) {
    var points = m.body.split('\n').filter(function(l) { return l.trim(); });
    outlineHtml = '<div class="outline-box"><div class="outline-title" style="display:flex;align-items:center;gap:7px;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--purple2)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect width="8" height="4" x="8" y="2" rx="1"/><path d="M9 14l2 2 4-4"/><line x1="9" y1="10" x2="15" y2="10"/></svg> Apa yang akan kamu pelajari</div><ul class="outline-list">' +
      points.map(function(o) { return '<li><span class="outline-dot"></span>' + escHtml(o) + '</li>'; }).join('') +
      '</ul></div>';
  }

  var quizHtml = '';
  if (m.quizzes && m.quizzes.length > 0) {
    var q = m.quizzes[quizIndex] || m.quizzes[0];
    var totalQ = m.quizzes.length;
    var isModDone = (m.status === 'done');

    var dotsHtml = m.quizzes.map(function(_, i) {
      var cls = '';
      if (isModDone || quizCorrect[i] === true) cls = ' done';
      else if (i === quizIndex) cls = ' cur';
      return '<div class="qz-dot' + cls + '" id="qd-' + i + '"></div>';
    }).join('');

    var modIdx = MODULES.findIndex(function(x) { return x.id === activeId; });
    var isLastModInCourse = (modIdx + 1 === MODULES.length);
    var nxtLabel = '';

    if (quizCorrect[quizIndex] === false) {
      nxtLabel = 'Coba Lagi 🔄';
    } else if (quizIndex + 1 < totalQ) {
      nxtLabel = 'Soal Selanjutnya →';
    } else if (!isLastModInCourse) {
      nxtLabel = 'Lanjut Modul Berikutnya →';
    } else {
      nxtLabel = isModDone ? 'Kembali ke Katalog Kursus →' : 'Selesaikan Kursus 🎉';
    }

    var isQAnswered = isModDone || (quizCorrect[quizIndex] !== undefined);
    var optsHtml = q.opts.map(function(o, i) {
      var optCls = 'quiz-option';
      if (isQAnswered) {
        optCls += ' dis';
        if (i === q.ans) optCls += ' cor';
      }
      return '<button class="' + optCls + '" id="qo-' + i + '" onclick="ansQ(' + i + ')">' + String.fromCharCode(65 + i) + '. ' + escHtml(o) + '</button>';
    }).join('');

    var fbHtml = '';
    if (isModDone || quizCorrect[quizIndex] === true) {
      fbHtml = '<div class="quiz-fb show cor" id="qz-fb">✅ <strong>Jawaban Benar:</strong> ' + escHtml(q.ex) + '</div>';
    } else if (quizCorrect[quizIndex] === false) {
      fbHtml = '<div class="quiz-fb show wrn" id="qz-fb">❌ <strong>Salah.</strong> ' + escHtml(q.ex) + '</div>';
    } else {
      fbHtml = '<div class="quiz-fb" id="qz-fb"></div>';
    }

    var nxtBtnCls = 'quiz-nxt' + (isQAnswered ? ' show' : '');

    quizHtml = '<div class="quiz-box">' +
      '<div class="quiz-top"><span class="quiz-badge">Quiz</span><span class="quiz-title">Uji Pemahaman (' + (quizIndex + 1) + '/' + totalQ + ')</span></div>' +
      '<div class="qz-prog" id="qz-prog">' + dotsHtml + '</div>' +
      '<div class="quiz-question" id="qz-q">' + escHtml(q.q) + '</div>' +
      '<div class="quiz-options" id="qz-opts">' + optsHtml + '</div>' +
      fbHtml +
      '<button class="' + nxtBtnCls + '" id="qz-nxt" onclick="nextQuizQ()">' + nxtLabel + '</button>' +
    '</div>';
  }

  panel.innerHTML =
    '<div class="main-header"><div class="main-icon">{{ $course->icon }}</div><div>' +
    '<div class="main-eyebrow">Modul ' + (MODULES.findIndex(function(x) { return x.id === activeId; }) + 1) + ' dari ' + MODULES.length + '</div>' +
    '<h2 class="main-title">' + escHtml(m.title) + '</h2></div></div>' +
    ytHtml + outlineHtml + quizHtml;
}

function ansQ(chosen) {
  if (!requireAuth()) return;
  var m = MODULES.find(function(x) { return x.id === activeId; });
  if (m.status === 'done') return;
  var q = m.quizzes[quizIndex];
  if (quizCorrect[quizIndex] !== undefined) return;

  var isCorrect = (chosen === q.ans);
  quizCorrect[quizIndex] = isCorrect;

  document.querySelectorAll('.quiz-option').forEach(function(o) { o.classList.add('dis'); });

  var fb = document.getElementById('qz-fb');
  var nxtBtn = document.getElementById('qz-nxt');
  var modIdx = MODULES.findIndex(function(x) { return x.id === activeId; });
  var isLastModInCourse = (modIdx + 1 === MODULES.length);

  if (isCorrect) {
    document.getElementById('qo-' + chosen).classList.add('cor');
    fb.className = 'quiz-fb show cor';
    fb.innerHTML = '✅ <strong>Benar!</strong> ' + escHtml(q.ex);

    if (quizIndex + 1 < m.quizzes.length) {
      nxtBtn.textContent = 'Soal Selanjutnya →';
    } else if (!isLastModInCourse) {
      nxtBtn.textContent = 'Lanjut Modul Berikutnya →';
    } else {
      nxtBtn.textContent = 'Selesaikan Kursus 🎉';
    }

    var dot = document.getElementById('qd-' + quizIndex);
    if (dot) { dot.className = 'qz-dot done'; }

    // Cek jika seluruh kuis di modul ini berhasil dijawab DENGAN BENAR
    var allCorrect = m.quizzes.every(function(_, i) { return quizCorrect[i] === true; });
    if (allCorrect && IS_AUTH) {
      var token = document.querySelector('meta[name="csrf-token"]');
      fetch('/modules/' + m.id + '/complete', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token.getAttribute('content'), 'Accept': 'application/json' },
        body: JSON.stringify({ score: 1 })
      }).then(function(r) { return r.json(); }).then(function(data) {
        m.status = 'done';
        var idx = MODULES.findIndex(function(x) { return x.id === activeId; });
        if (idx + 1 < MODULES.length && MODULES[idx + 1].status === 'locked') {
          MODULES[idx + 1].status = 'active';
        }
        renderSidebar();
        updateProgress();
      }).catch(function() {});
    }
  } else {
    // Jika SALAH
    document.getElementById('qo-' + chosen).classList.add('wrn');
    document.getElementById('qo-' + q.ans).classList.add('cor');
    fb.className = 'quiz-fb show wrn';
    fb.innerHTML = '❌ <strong>Salah.</strong> ' + escHtml(q.ex);
    nxtBtn.textContent = 'Coba Lagi 🔄';
  }

  nxtBtn.classList.add('show');
}

function nextQuizQ() {
  if (!requireAuth()) return;
  var m = MODULES.find(function(x) { return x.id === activeId; });

  // Jika jawaban sebelumnya SALAH, klik "Coba Lagi 🔄" akan mereset soal ini
  if (quizCorrect[quizIndex] === false) {
    delete quizCorrect[quizIndex];
    renderMain();
    return;
  }

  if (quizIndex + 1 < m.quizzes.length) {
    quizIndex++;
    renderMain();
  } else {
    if (m.status === 'done') {
      var idx = MODULES.findIndex(function(x) { return x.id === activeId; });
      if (idx + 1 < MODULES.length) {
        if (MODULES[idx + 1].status === 'locked') {
          MODULES[idx + 1].status = 'active';
        }
        selectModule(MODULES[idx + 1].id);
      } else {
        window.location.href = "{{ route('courses') }}?completed=1&course=" + COURSE_ID;
      }
    }
  }
}

function updateProgress() {
  var done = MODULES.filter(function(x) { return x.status === 'done'; }).length;
  var pct = Math.round((done / MODULES.length) * 100);
  document.getElementById('prog-fill').style.width = pct + '%';
  document.getElementById('prog-text').textContent = done + ' dari ' + MODULES.length + ' modul selesai';
}

function escHtml(s) { return String(s).replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

// Render awal
renderMain();
</script>
@endpush
