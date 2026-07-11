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
            <a href="{{ route('home') }}" class="logo">
                <x-cs-logo />
            </a>
            @php
                $isAdminUser = auth()->check() && auth()->user()->isAdmin();
                $previewMode = (bool) session('admin_preview_mode', false);
                $showUserNav = !$isAdminUser || $previewMode;
            @endphp
            <div class="nav-links">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                @if ($showUserNav)
                    <a href="{{ route('courses') }}"
                        class="nav-link {{ request()->routeIs('courses') ? 'active' : '' }}">Courses</a>
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
                    @if ($isAdminUser)
                        @if ($previewMode)
                            <form method="POST" action="{{ route('admin.preview.off') }}" class="nav-form">
                                @csrf
                                <button type="submit" class="btn-g btn-g--back">
                                    <x-cs-icon name="arrow-left" size="14" /> Kembali ke Admin
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.preview.on') }}" class="nav-form">
                                @csrf
                                <button type="submit" class="btn-g">
                                    <x-cs-icon name="eye" size="14" /> Lihat sebagai User
                                </button>
                            </form>
                        @endif
                    @endif
                    <div class="user-badge">
                        <span class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        <span class="uname">{{ auth()->user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="nav-form">
                        @csrf
                        <button type="submit" class="btn-g">
                            <x-cs-icon name="log-out" size="14" /> Keluar
                        </button>
                    </form>
                @else
                    <button class="btn-g" onclick="openModal('login')">Masuk</button>
                    <button class="btn-p" onclick="openModal('register')">Daftar Gratis</button>
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
                <p id="modalSub">Masuk ke akunmu dan lanjut belajar</p>
            </div>

            <div class="modal-tabs">
                <button class="modal-tab active" id="tab-login" onclick="switchTab('login')">Masuk</button>
                <button class="modal-tab" id="tab-register" onclick="switchTab('register')">Daftar Gratis</button>
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
                        <div class="modal-forgot">
                            <a href="{{ route('password.request') }}">Lupa password?</a>
                        </div>
                    </div>
                    <button type="submit" class="btn-full">Masuk →</button>
                    <div class="modal-demo">
                        Demo: <strong>demo@cs2.id / Demo1234!</strong>
                    </div>
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
                document.getElementById('modalTitle').textContent = 'Buat Akun Baru';
                document.getElementById('modalSub').textContent = 'Gratis, gak perlu kartu kredit. Daftar sekarang!';
            }
        }
        // Tutup modal kalau klik di luar box
        document.getElementById('authModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
        // Buka modal otomatis jika ada error validasi dari Breeze
        @if ($errors->hasBag('default') || $errors->any())
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
</body>

</html>
