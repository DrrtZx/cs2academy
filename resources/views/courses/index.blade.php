@extends('layouts.app')
@section('title', 'Kursus')

@push('styles')
<style>
.catalog-wrap { max-width: 1280px; margin: 0 auto; padding: 3rem 2rem; }
.catalog-head { margin-bottom: 28px; }
.catalog-eyebrow { font-size: 12px; font-weight: 700; letter-spacing: 0.08em; color: var(--purple); text-transform: uppercase; margin-bottom: 8px; }
.catalog-title { font-size: 26px; font-weight: 800; margin: 0 0 8px; color: var(--text); }
.catalog-sub { font-size: 14.5px; color: var(--text2); margin: 0; }

.grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 22px; margin-top: 24px; }

.card { background: var(--bg2); border: 1px solid var(--border); border-radius: 16px; padding: 22px; cursor: pointer; transition: transform 0.15s ease, border-color 0.15s ease, background 0.15s ease; display: flex; flex-direction: column; position: relative; overflow: hidden; text-decoration: none; color: inherit; }
.card:hover { transform: translateY(-3px); border-color: rgba(139,123,255,0.45); background: var(--bg3); }
.card.locked { cursor: default; opacity: 0.55; }
.card.locked:hover { transform: none; border-color: var(--border); background: var(--bg2); }

.card-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
.card-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 21px; background: linear-gradient(135deg, rgba(139,123,255,0.22), rgba(63,216,255,0.16)); flex-shrink: 0; }
.badges { display: flex; gap: 6px; }
.badge { font-size: 10.5px; font-weight: 700; padding: 3px 9px; border-radius: 999px; letter-spacing: 0.02em; }
.badge-type { background: rgba(139,123,255,0.16); color: var(--purple2); }
.badge-popular { background: rgba(255,171,92,0.16); color: var(--orange); }
.badge-done { background: rgba(43,230,186,0.16); color: var(--green); }

.card-title { font-size: 17.5px; font-weight: 700; color: var(--text); margin: 0 0 8px; line-height: 1.35; }
.card-desc { font-size: 13px; color: var(--text2); line-height: 1.5; margin: 0 0 18px; flex: 1; }

.card-meta { display: flex; flex-wrap: wrap; gap: 14px; font-size: 12.5px; color: var(--text3); padding-top: 14px; border-top: 1px solid rgba(255,255,255,0.05); }
.card-meta span { display: flex; align-items: center; gap: 5px; }

.card-progress { margin-top: 14px; }
.card-progress-bar { height: 5px; background: rgba(255,255,255,0.06); border-radius: 999px; overflow: hidden; margin-bottom: 6px; }
.card-progress-fill { height: 100%; background: var(--grad-primary); border-radius: 999px; transition: width .5s; }
.card-progress-text { font-size: 11.5px; color: var(--text3); }

.lock-overlay { position: absolute; top: 18px; right: 18px; color: var(--text3); }

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
      <p style="font-size:0.82rem;color:var(--text2);">Buat akun gratis dulu yuk untuk akses seluruh materi & latihan CS2.</p>
    </div>
    <div style="padding:1.5rem 1.75rem;display:flex;flex-direction:column;gap:10px;">
      <button class="btn-full" onclick="document.getElementById('guestModal').classList.remove('open');openModal('login');">Masuk ke Akun</button>
      <button onclick="document.getElementById('guestModal').classList.remove('open');openModal('register');" style="width:100%;padding:11px;border-radius:10px;border:1px solid var(--border);background:transparent;color:var(--text);font-size:0.9rem;font-weight:600;cursor:pointer;">Daftar Akun &rarr;</button>
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

<div class="catalog-wrap">
  @if(request('completed'))
    <div style="background:rgba(43,230,186,0.12);border:1px solid rgba(43,230,186,0.3);border-radius:12px;padding:14px 18px;margin-bottom:24px;display:flex;align-items:center;gap:12px;color:var(--green);font-size:0.9rem;font-weight:600;">
      <x-cs-icon name="trophy" size="20" stroke="2" />
      <div>🎉 Selamat! Kamu telah menyelesaikan seluruh modul pada kursus tersebut. Kursus berikutnya sudah terbuka!</div>
    </div>
  @endif

  <div class="catalog-head">
    <div class="catalog-eyebrow">Kursus</div>
    <h1 class="catalog-title">Pilih Kursus CS2 Kamu</h1>
    <p class="catalog-sub">Materi terstruktur dari fundamental sampai strategi pro match — pilih topik yang mau kamu matangkan hari ini.</p>
  </div>

  <div class="grid">
    @foreach($coursesData as $c)
      @php $locked = !$c['unlocked']; @endphp
      @if($locked)
        <div class="card locked">
          <div class="lock-overlay">
            <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 1a4 4 0 00-4 4v2H5a1 1 0 00-1 1v9a1 1 0 001 1h10a1 1 0 001-1V8a1 1 0 00-1-1h-1V5a4 4 0 00-4-4zm2 6V5a2 2 0 10-4 0v2h4z" clip-rule="evenodd"/></svg>
          </div>
      @else
        <a href="{{ route('courses.show', $c['id']) }}" class="card">
      @endif
        <div class="card-top">
          <div class="card-icon">{{ $c['icon'] }}</div>
          <div class="badges">
            <span class="badge badge-type">{{ $c['type'] }}</span>
            @if($c['is_popular'])<span class="badge badge-popular">🔥 Populer</span>@endif
            @if($c['progress'] === 100)<span class="badge badge-done">✓ Selesai</span>@endif
          </div>
        </div>
        <h3 class="card-title">{{ $c['title'] }}</h3>
        <p class="card-desc">{{ $c['body'] }}</p>
        <div class="card-meta">
          <span style="display:inline-flex;align-items:center;gap:4px;"><x-cs-icon name="clock" size="13" stroke="2" /> {{ $c['durasi'] }}</span>
          <span style="display:inline-flex;align-items:center;gap:4px;"><x-cs-icon name="book-open" size="13" stroke="2" /> {{ $c['level'] }}</span>
          <span style="display:inline-flex;align-items:center;gap:4px;"><x-cs-icon name="clipboard-list" size="13" stroke="2" /> {{ $c['modules_count'] }} modul</span>
          <span style="display:inline-flex;align-items:center;gap:4px;"><x-cs-icon name="sparkles" size="13" stroke="2" /> {{ $c['quizzes_count'] }} quiz</span>
        </div>
        @if(!$locked && $c['progress'] > 0 && $c['progress'] < 100)
        <div class="card-progress">
          <div class="card-progress-bar"><div class="card-progress-fill" style="width:{{ $c['progress'] }}%"></div></div>
          <div class="card-progress-text">{{ $c['progress'] }}% selesai — lanjutkan belajar</div>
        </div>
        @endif
        @if($c['progress'] === 100)
        <div class="card-progress-text" style="margin-top:12px;color:var(--green);display:flex;align-items:center;gap:6px;"><x-cs-icon name="check-circle" size="14" stroke="2.5" /> Selesai — semua modul sudah dikerjakan</div>
        @endif
        @if($locked)
        <div class="card-progress-text" style="margin-top:12px;display:flex;align-items:center;gap:6px;"><x-cs-icon name="lock" size="13" stroke="2.5" /> Selesaikan kursus sebelumnya dulu</div>
        @endif
      @if(!$locked)
        </a>
      @else
        </div>
      @endif
    @endforeach
  </div>
</div>
@endsection
