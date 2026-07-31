<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>CS2 Academy — @yield('title', 'Platform CS2 #1 Indonesia')</title>
    <link rel="stylesheet" href="/css/app.css" />
    @stack('styles')
</head>

<body>

    <nav>
        <div class="nav-inner">
            @php
                $isAdminUser = auth()->check() && auth()->user()->isAdmin();
                $previewMode = (bool) session('admin_preview_mode', false);
                $showUserNav = !$isAdminUser || $previewMode;
                $logoUrl     = ($isAdminUser && !$previewMode) ? route('admin.dashboard') : route('home');
            @endphp
            <a href="{{ $logoUrl }}" class="logo">
                <x-cs-logo />
            </a>
            <div class="nav-links">
                @if ($showUserNav)
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('courses') }}"
                        class="nav-link {{ request()->routeIs('courses') ? 'active' : '' }}">Kursus</a>
                    <a href="{{ route('coaching') }}"
                        class="nav-link {{ request()->routeIs('coaching') ? 'active' : '' }}">Coaching</a>
                @endif
                @auth
                    @if ($showUserNav && auth()->user()->assignments()->exists())
                        <a href="{{ route('assignments.index') }}"
                            class="nav-link {{ request()->routeIs('assignments.*') ? 'active' : '' }}">Tugas Saya</a>
                    @endif
                    @if ($isAdminUser && !$previewMode)
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link nav-link--admin {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                            <x-cs-icon name="settings" size="14" stroke="2" /> Admin
                        </a>
                    @endif
                @endauth
            </div>
            <div class="nav-right">
                @auth
                    @if ($isAdminUser && $previewMode)
                        <form method="POST" action="{{ route('admin.preview.off') }}" class="nav-form">
                            @csrf
                            <button type="submit" class="btn-g btn-g--back">
                                <x-cs-icon name="arrow-left" size="14" /> Kembali ke Admin
                            </button>
                        </form>
                    @endif
                    <div class="user-badge" style="position:relative; cursor:pointer;" onclick="this.querySelector('.user-drop').classList.toggle('open')">
                        <span class="user-avatar" style="position:relative; overflow:hidden;">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="avatar" style="width:100%;height:100%;object-fit:cover;">
                            @else
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            @endif
                            @if(!$isAdminUser && auth()->user()->hasPendingCoaching())
                                <span class="coaching-dot" title="Sesi coaching aktif"></span>
                            @endif
                        </span>
                        <span class="uname">{{ auth()->user()->name }}</span>
                        <div class="user-drop" style="display:none;position:absolute;top:100%;right:0;margin-top:10px;background:var(--bg2);border:1px solid var(--border);border-radius:14px;min-width:220px;box-shadow:0 12px 32px rgba(0,0,0,.5);z-index:200;overflow:hidden;">
                            @if(!$isAdminUser && auth()->user()->hasPendingCoaching())
                                <a href="{{ route('assignments.index') }}" style="display:flex;align-items:center;gap:10px;padding:12px 16px;font-size:12px;text-decoration:none;border-bottom:1px solid var(--border);">
                                    <span style="width:10px;height:10px;border-radius:50%;background:var(--green);flex-shrink:0;animation:coaching-pulse 2s infinite;"></span>
                                    <span style="color:var(--green);font-weight:700;">1 Sesi Aktif</span>
                                    <span style="color:var(--text2);font-size:11px;margin-left:auto;">Tugas Saya →</span>
                                </a>
                            @endif
                            <a href="{{ route('profile.edit') }}" style="display:flex;align-items:center;gap:10px;padding:12px 16px;font-size:13px;color:var(--text);text-decoration:none;">Profile Settings</a>
                            <div style="border-top:1px solid var(--border);">
                                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                                    @csrf
                                    <button type="submit" style="width:100%;text-align:left;background:none;border:none;padding:12px 16px;font-size:13px;color:var(--text2);cursor:pointer;font-family:inherit;">Keluar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="nav-form" style="display:none;">
                        @csrf
                        <button type="submit" class="btn-g">
                            <x-cs-icon name="log-out" size="14" /> Keluar
                        </button>
                    </form>
                @else
                    <button class="btn-g" onclick="openModal('login')">Masuk</button>
                    <button class="btn-p" onclick="openModal('register')">Daftar Akun</button>
                @endauth
            </div>
        </div>
    </nav>

    @if (session('success'))
        <div class="alert alert-success">
            <x-cs-icon name="check-circle" size="16" /> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">
            <x-cs-icon name="x-circle" size="16" /> {{ session('error') }}
        </div>
    @endif
    @if ($errors->any() && !request()->routeIs('login') && !request()->routeIs('register'))
        <div class="alert alert-error">
            <x-cs-icon name="x-circle" size="16" /> {{ $errors->first() }}
        </div>
    @endif

    @yield('content')

    <footer>
        <x-cs-logo size="22" />
        <div class="foot-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Kontak</a>
            <a href="#">FAQ</a>
        </div>
        <div class="foot-copy">© {{ date('Y') }} CS2Academy. All rights reserved.</div>
    </footer>

    {{-- ══════════════════════════════════
     MODAL AUTH (Login + Register)
     ══════════════════════════════════ --}}
    <div class="modal-overlay" id="authModal">
        <div class="modal-box">
            <button class="modal-close" onclick="closeModal()">
                <x-cs-icon name="x" size="16" />
            </button>

            <div class="modal-head">
                <div class="modal-logo"><x-cs-logo size="20" /></div>
                <h3 id="modalTitle">Selamat Datang</h3>
                <p id="modalSub">Masuk ke akun CS2Academy kamu</p>
            </div>

            <div class="modal-tabs">
                <button class="modal-tab active" id="tab-login" onclick="switchTab('login')">Masuk</button>
                <button class="modal-tab" id="tab-register" onclick="switchTab('register')">Daftar Akun</button>
            </div>

            {{-- LOGIN PANE --}}
            <div class="modal-pane active" id="pane-login">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                    <div class="f-group">
                        <label class="f-label">Email</label>
                        <input type="email" name="email" class="f-inp" placeholder="email@kamu.com" required
                            autofocus value="{{ old('email') }}">
                    </div>
                    <div class="f-group">
                        <label class="f-label">Password</label>
                        <input type="password" name="password" class="f-inp" placeholder="Password kamu" required>
                    </div>
                    <button type="submit" class="btn-full">Masuk →</button>
                </form>
            </div>

            {{-- REGISTER PANE --}}
            <div class="modal-pane" id="pane-register">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="f-group">
                        <label class="f-label">Nama Lengkap</label>
                        <input type="text" name="name" class="f-inp" placeholder="Nama kamu" required
                            value="{{ old('name') }}">
                    </div>
                    <div class="f-group">
                        <label class="f-label">Email</label>
                        <input type="email" name="email" class="f-inp" placeholder="email@kamu.com" required
                            value="{{ old('email') }}">
                    </div>
                    <div class="f-group">
                        <label class="f-label">Password</label>
                        <input type="password" name="password" class="f-inp" placeholder="Minimal 8 karakter" required>
                    </div>
                    <div class="f-group">
                        <label class="f-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="f-inp"
                            placeholder="Ulangi password" required>
                    </div>
                    <button type="submit" class="btn-full">Buat Akun →</button>
                </form>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════
     POPUP BERHASIL REGISTER
     ══════════════════════════════════ --}}
    <div class="success-overlay" id="successRegister">
        <div class="success-box">
            <span class="success-ic">
                <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="28" cy="28" r="27" stroke="url(#sg)" stroke-width="2"/>
                    <path d="M17 28l8 8 14-14" stroke="url(#sg)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <defs>
                        <linearGradient id="sg" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#2be6ba"/>
                            <stop offset="100%" stop-color="#3fd8ff"/>
                        </linearGradient>
                    </defs>
                </svg>
            </span>
            <h3>Akun Berhasil Dibuat!</h3>
            <p>Selamat datang di <strong>CS2Academy</strong>!<br>
                Akun kamu udah aktif. Sekarang langsung mulai belajar atau pesan sesi coaching pertamamu.</p>
            <button class="success-btn" onclick="closeSuccessPopup()">
                <x-cs-icon name="rocket" size="16" stroke="2" /> Mulai Sekarang!
            </button>
        </div>
    </div>

    @stack('scripts')
    <script>
        // ── Modal Auth ──
        function openModal(tab = 'login') {
            document.getElementById('authModal').classList.add('open');
            switchTab(tab);
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('authModal').classList.remove('open');
            document.body.style.overflow = '';
        }

        function switchTab(tab) {
            document.querySelectorAll('.modal-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.modal-pane').forEach(p => p.classList.remove('active'));
            document.getElementById('tab-' + tab).classList.add('active');
            document.getElementById('pane-' + tab).classList.add('active');
            if (tab === 'login') {
                document.getElementById('modalTitle').textContent = 'Selamat Datang';
                document.getElementById('modalSub').textContent = 'Masuk ke akun CS2Academy kamu';
            } else {
                document.getElementById('modalTitle').textContent = 'Daftar Akun Baru';
                document.getElementById('modalSub').textContent = 'Buat akun CS2Academy untuk mulai belajar dan konsultasi dengan coach';
            }
        }
        // Tutup modal kalau klik di luar box
        document.getElementById('authModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
        // Tutup user dropdown kalau klik di luar
        document.addEventListener('click', function(e) {
            document.querySelectorAll('.user-drop.open').forEach(function(d) {
                if (!d.parentElement.contains(e.target)) d.classList.remove('open');
            });
        });
        // Buka modal otomatis jika ada error validasi dari Breeze (auth forms only)
        @if ($errors->any() && (request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('password.*')))
            document.addEventListener('DOMContentLoaded', function() {
                @if (old('name') || old('password_confirmation'))
                    openModal('register');
                @else
                    openModal('login');
                @endif
            });
        @endif

        // ── Popup Berhasil Register ──
        function closeSuccessPopup() {
            document.getElementById('successRegister').classList.remove('open');
            document.body.style.overflow = '';
        }
        @if (session('registered'))
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('successRegister').classList.add('open');
                document.body.style.overflow = 'hidden';
            });
        @endif
    </script>

    {{-- ══════════════════════════════════
     MODAL CONFIRMATION (Custom Styled)
     ══════════════════════════════════ --}}
    <div class="modal-overlay" id="confirmModal" style="z-index: 20000;">
        <div class="modal-box" style="max-width:400px;padding:1.75rem 1.5rem;text-align:center;">
            <h3 id="confirmTitle" style="font-size:1.15rem;font-weight:800;margin-bottom:0.4rem;color:var(--text);">Konfirmasi</h3>
            <p id="confirmText" style="font-size:0.85rem;color:var(--text2);line-height:1.5;margin-bottom:1.5rem;">Apakah kamu yakin ingin melanjutkan?</p>
            <div style="display:flex;gap:10px;justify-content:center;">
                <button type="button" id="confirmCancelBtn" onclick="closeConfirmModal()" style="flex:1;padding:10px;border-radius:10px;border:1px solid var(--border);background:var(--bg3);color:var(--text2);font-size:0.85rem;font-weight:700;cursor:pointer;">Batal</button>
                <button type="button" id="confirmActionBtn" style="flex:1;padding:10px;border-radius:10px;border:none;background:var(--grad-primary);color:#fff;font-size:0.85rem;font-weight:700;cursor:pointer;box-shadow:0 8px 20px -8px rgba(139,123,255,0.7);">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>

    <script>
    let _confirmCallback = null;
    function showCustomConfirm(options) {
      const modal = document.getElementById('confirmModal');
      const title = document.getElementById('confirmTitle');
      const text  = document.getElementById('confirmText');
      const actBtn = document.getElementById('confirmActionBtn');

      if (options.title) title.textContent = options.title;
      if (options.text) text.textContent = options.text;
      if (options.confirmText) actBtn.textContent = options.confirmText;
      if (options.danger) {
        actBtn.style.background = '#ff5f5f';
        actBtn.style.boxShadow = '0 8px 20px -8px rgba(255,95,95,0.7)';
      } else {
        actBtn.style.background = 'var(--grad-primary)';
        actBtn.style.boxShadow = '0 8px 20px -8px rgba(139,123,255,0.7)';
      }

      _confirmCallback = options.onConfirm || null;
      modal.classList.add('open');
      document.body.style.overflow = 'hidden';
    }

    function closeConfirmModal() {
      const modal = document.getElementById('confirmModal');
      modal.classList.remove('open');
      document.body.style.overflow = '';
      _confirmCallback = null;
    }

    document.getElementById('confirmActionBtn').addEventListener('click', function() {
      if (_confirmCallback) _confirmCallback();
      closeConfirmModal();
    });

    document.getElementById('confirmModal').addEventListener('click', function(e) {
      if (e.target === this) closeConfirmModal();
    });
    </script>

    {{-- Admin floating chat widget --}}
    @auth
        @if(auth()->user()->isAdmin())
            <x-admin-chat-widget />
        @endif
    @endauth
</body>

</html>
