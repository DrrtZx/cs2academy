@extends('layouts.app')
@section('title', 'Admin Panel')

@push('styles')
    <link rel="stylesheet" href="/css/admin.css" />
    <style>
        /* ── Live Search User ── */
        .user-search-wrap { position: relative; }
        .user-search-input {
            width: 100%;
            background: var(--bg);
            border: 1.5px solid var(--border);
            color: var(--text);
            padding: 11px 14px;
            border-radius: 10px;
            font-size: 0.9rem;
            outline: none;
            transition: border-color .2s;
            box-sizing: border-box;
        }
        .user-search-input:focus { border-color: var(--purple); }
        .user-search-input::placeholder { color: var(--text3); }

        .user-dropdown {
            position: absolute;
            top: calc(100% + 4px);
            left: 0; right: 0;
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,.35);
            z-index: 50;
            overflow: hidden;
            display: none;
        }
        .user-dropdown.open { display: block; }

        .user-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            cursor: pointer;
            transition: background .15s;
        }
        .user-option:hover { background: var(--bg3); }
        .user-option-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--purple), var(--cyan));
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .user-option-info { flex: 1; min-width: 0; }
        .user-option-name { font-size: 0.88rem; font-weight: 700; color: var(--text); }
        .user-option-email { font-size: 0.75rem; color: var(--text3); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-paid-badge {
            font-size: 0.65rem; font-weight: 700;
            background: rgba(0,212,170,.15); color: var(--green);
            padding: 2px 7px; border-radius: 50px;
            white-space: nowrap;
        }
        .user-empty { padding: 14px; text-align: center; color: var(--text3); font-size: 0.84rem; }

        /* Selected user card */
        .selected-user-card {
            display: none;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            background: rgba(124,111,224,.08);
            border: 1.5px solid var(--purple);
            border-radius: 10px;
            margin-top: 8px;
        }
        .selected-user-card.show { display: flex; }
        .selected-user-card-info { flex: 1; }
        .selected-user-card-name { font-size: 0.9rem; font-weight: 700; }
        .selected-user-card-email { font-size: 0.75rem; color: var(--text3); }
        .clear-user-btn {
            background: none; border: none; color: var(--text3);
            cursor: pointer; font-size: 1rem; padding: 4px;
            line-height: 1;
        }
        .clear-user-btn:hover { color: var(--red); }

        /* Send form */
        .send-form-label {
            font-size: 0.72rem; font-weight: 700;
            color: var(--text2); text-transform: uppercase;
            letter-spacing: .5px; margin-bottom: 6px; margin-top: 1rem;
            display: block;
        }
        .send-form-input {
            width: 100%;
            background: var(--bg);
            border: 1.5px solid var(--border);
            color: var(--text);
            padding: 11px 14px;
            border-radius: 10px;
            font-size: 0.9rem;
            outline: none;
            box-sizing: border-box;
            transition: border-color .2s;
        }
        .send-form-input:focus { border-color: var(--purple); }
        .send-form-input::placeholder { color: var(--text3); }
        textarea.send-form-input { resize: vertical; min-height: 110px; }

        .send-btn {
            width: 100%; margin-top: 1.1rem;
            background: var(--grad-primary); color: #fff;
            border: none; padding: 12px; border-radius: 10px;
            font-size: 0.9rem; font-weight: 700; cursor: pointer;
            box-shadow: 0 10px 24px -10px rgba(139,123,255,.65);
            transition: all .2s; display: flex; align-items: center;
            justify-content: center; gap: 8px;
        }
        .send-btn:hover { filter: brightness(1.08); transform: translateY(-1px); }
        .send-btn:disabled { opacity: .5; cursor: not-allowed; transform: none; }

        /* Tab active state for "kirim" tab */
        .admin-tab.send-tab.active {
            background: rgba(0,212,170,.12);
            border-color: var(--green);
            color: var(--green);
        }

        /* Sent history section */
        .sent-history-title {
            font-size: 0.72rem; font-weight: 700;
            color: var(--text3); text-transform: uppercase;
            letter-spacing: .5px; margin: 1.5rem 0 .75rem;
        }
        .sent-card {
            background: var(--bg3);
            border: 1px solid var(--border);
            border-radius: 11px;
            padding: 1rem 1.2rem;
            margin-bottom: .75rem;
        }
        .sent-card-header {
            display: flex; justify-content: space-between;
            align-items: flex-start; margin-bottom: .5rem;
        }
        .sent-card-title { font-size: .9rem; font-weight: 700; }
        .sent-card-meta { font-size: .72rem; color: var(--text3); margin-top: 2px; }
        .sent-card-body { font-size: .84rem; color: var(--text2); line-height: 1.65; }
        .badge-sent {
            font-size: .65rem; font-weight: 700; padding: 2px 8px;
            border-radius: 50px;
            background: rgba(79,195,247,.15); color: var(--blue);
            white-space: nowrap;
        }
    </style>
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
    <a href="{{ route('admin.assignments') }}" class="admin-tab {{ request()->query('tab') !== 'kirim' ? 'active' : '' }}">
      <x-cs-icon name="clipboard-list" size="14" stroke="2" /> Tugas Masuk
      <span class="admin-tab-badge">{{ $incomingCount }}</span>
    </a>
    <a href="{{ route('admin.assignments') }}?tab=kirim" class="admin-tab send-tab {{ request()->query('tab') === 'kirim' ? 'active' : '' }}">
      <x-cs-icon name="send" size="14" stroke="2" /> Kirim ke User
    </a>
    <a href="{{ route('admin.quiz') }}" class="admin-tab">
      <x-cs-icon name="lightbulb" size="14" stroke="2" /> Kelola Quiz
    </a>
  </div>

  {{-- ══ TAB: TUGAS MASUK (default) ══ --}}
  @if(request()->query('tab') !== 'kirim')

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

  @else
  {{-- ══ TAB: KIRIM KE USER ══ --}}

    <div style="max-width:560px;">

      {{-- Form Kirim --}}
      <div class="admin-card" style="margin-bottom:1.75rem;">
        <div style="font-size:1rem;font-weight:700;margin-bottom:1.25rem;display:flex;align-items:center;gap:8px;">
          <x-cs-icon name="send" size="16" stroke="2" style="color:var(--green)" />
          Kirim Pesan / Tugas ke User
        </div>

        <form method="POST" action="{{ route('admin.send-to-user') }}" id="sendForm">
          @csrf
          <input type="hidden" name="user_id" id="selectedUserId">

          {{-- Search User --}}
          <label class="send-form-label">Pilih User Penerima</label>
          <div class="user-search-wrap">
            <input
              type="text"
              id="userSearchInput"
              class="user-search-input"
              placeholder="Cari nama atau email user..."
              autocomplete="off"
            >
            <div class="user-dropdown" id="userDropdown"></div>
          </div>

          {{-- Selected User Card --}}
          <div class="selected-user-card" id="selectedUserCard">
            <div class="user-option-avatar" id="selectedUserAvatar"></div>
            <div class="selected-user-card-info">
              <div class="selected-user-card-name" id="selectedUserName"></div>
              <div class="selected-user-card-email" id="selectedUserEmail"></div>
            </div>
            <button type="button" class="clear-user-btn" onclick="clearUser()" title="Ganti user">✕</button>
          </div>

          @error('user_id')
            <p style="color:var(--red);font-size:.8rem;margin-top:.4rem;">{{ $message }}</p>
          @enderror

          {{-- Judul --}}
          <label class="send-form-label">Judul Pesan</label>
          <input
            type="text"
            name="judul"
            class="send-form-input"
            placeholder="Contoh: Link Discord Sesi Coaching, Tugas Latihan Aim, dll."
            value="{{ old('judul') }}"
            required
          >
          @error('judul')
            <p style="color:var(--red);font-size:.8rem;margin-top:.4rem;">{{ $message }}</p>
          @enderror

          {{-- Isi Pesan --}}
          <label class="send-form-label">Isi Pesan / Link / Instruksi</label>
          <textarea
            name="tugas_teks"
            class="send-form-input"
            placeholder="Contoh: Halo! Ini link Discord kita buat sesi coaching: discord.gg/xxxxx&#10;Masuk jam 8 malam ya, coach udah standby."
            required
          >{{ old('tugas_teks') }}</textarea>
          @error('tugas_teks')
            <p style="color:var(--red);font-size:.8rem;margin-top:.4rem;">{{ $message }}</p>
          @enderror

          <button type="submit" class="send-btn" id="sendBtn" disabled>
            <x-cs-icon name="send" size="15" stroke="2" /> Kirim ke User
          </button>
        </form>
      </div>

      {{-- Riwayat kiriman dari admin --}}
      @if($sentByAdmin->count())
        <div class="sent-history-title">📬 Riwayat Kiriman dari Admin</div>
        @foreach($sentByAdmin as $item)
          <div class="sent-card">
            <div class="sent-card-header">
              <div>
                <div class="sent-card-title">{{ $item->judul }}</div>
                <div class="sent-card-meta">
                  Ke: <strong>{{ $item->user->name }}</strong>
                  · {{ $item->user->email }}
                  · {{ $item->created_at->diffForHumans() }}
                </div>
              </div>
              <span class="badge-sent">📨 Terkirim</span>
            </div>
            <div class="sent-card-body">{{ $item->tugas_teks }}</div>
          </div>
        @endforeach
      @else
        <div style="text-align:center;padding:2rem;color:var(--text3);font-size:.84rem;">
          Belum ada pesan yang dikirim ke user.
        </div>
      @endif
    </div>

  @endif

</div>
@endsection

@push('scripts')
<script>
(function () {
  const searchInput  = document.getElementById('userSearchInput');
  const dropdown     = document.getElementById('userDropdown');
  const hiddenId     = document.getElementById('selectedUserId');
  const selectedCard = document.getElementById('selectedUserCard');
  const selectedName = document.getElementById('selectedUserName');
  const selectedEmail= document.getElementById('selectedUserEmail');
  const selectedAvatar = document.getElementById('selectedUserAvatar');
  const sendBtn      = document.getElementById('sendBtn');

  if (!searchInput) return; // tab tugas masuk tidak punya elemen ini

  let debounceTimer;

  searchInput.addEventListener('input', function () {
    clearTimeout(debounceTimer);
    const q = this.value.trim();
    if (q.length < 2) { dropdown.classList.remove('open'); dropdown.innerHTML = ''; return; }
    debounceTimer = setTimeout(() => fetchUsers(q), 280);
  });

  // Tutup dropdown kalau klik di luar
  document.addEventListener('click', function (e) {
    if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
      dropdown.classList.remove('open');
    }
  });

  function fetchUsers(q) {
    const url = '{{ route('admin.users.search') }}?q=' + encodeURIComponent(q);
    fetch(url, { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
      .then(r => r.json())
      .then(users => renderDropdown(users))
      .catch(() => {});
  }

  function renderDropdown(users) {
    dropdown.innerHTML = '';
    if (!users.length) {
      dropdown.innerHTML = '<div class="user-empty">Tidak ada user yang cocok.</div>';
      dropdown.classList.add('open');
      return;
    }
    users.forEach(u => {
      const el = document.createElement('div');
      el.className = 'user-option';
      el.innerHTML = `
        <div class="user-option-avatar">${u.name.charAt(0).toUpperCase()}</div>
        <div class="user-option-info">
          <div class="user-option-name">${escHtml(u.name)}</div>
          <div class="user-option-email">${escHtml(u.email)}</div>
        </div>
        ${u.has_paid ? '<span class="user-paid-badge">✓ Sudah Beli</span>' : ''}
      `;
      el.addEventListener('click', () => selectUser(u));
      dropdown.appendChild(el);
    });
    dropdown.classList.add('open');
  }

  function selectUser(u) {
    hiddenId.value = u.id;
    selectedName.textContent  = u.name;
    selectedEmail.textContent = u.email;
    selectedAvatar.textContent = u.name.charAt(0).toUpperCase();
    selectedCard.classList.add('show');
    searchInput.value = '';
    dropdown.classList.remove('open');
    dropdown.innerHTML = '';
    sendBtn.disabled = false;
  }

  window.clearUser = function () {
    hiddenId.value = '';
    selectedCard.classList.remove('show');
    sendBtn.disabled = true;
    searchInput.value = '';
    searchInput.focus();
  };

  function escHtml(s) {
    return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }
})();
</script>
@endpush
