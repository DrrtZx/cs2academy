@extends('layouts.app')
@section('title', 'Coaching')

@push('styles')
    <style>
        .coaching-wrap {
            max-width: 1280px;
            margin: 0 auto;
            padding: 3.5rem 2rem;
        }

        .tabs-wrapper {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
        }

        .tab-btns {
            display: flex;
            background: var(--bg3);
            padding: 5px;
            gap: 4px;
        }

        .tab-btn {
            flex: 1;
            padding: 8px;
            border-radius: 9px;
            border: none;
            background: transparent;
            color: var(--text2);
            font-size: 0.85rem;
            cursor: pointer;
            font-weight: 600;
            transition: all .2s;
        }

        .tab-btn.active {
            background: var(--grad-primary);
            color: #fff;
        }

        .tab-c {
            display: none;
            padding: 1.75rem;
        }

        .tab-c.active {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.75rem;
            align-items: start;
        }

        .svc-card {
            background: var(--bg3);
            border-radius: 12px;
            padding: 1.4rem;
        }

        .svc-ic {
            width: 44px;
            height: 44px;
            background: rgba(139, 123, 255, 0.12);
            border: 1px solid rgba(139, 123, 255, 0.25);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.9rem;
            color: var(--purple2);
        }

        .svc-card h3 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .svc-card p {
            color: var(--text2);
            font-size: 0.84rem;
            line-height: 1.7;
        }

        .price-box {
            background: var(--bg3);
            border: 1px solid var(--purple);
            border-radius: 13px;
            padding: 1.5rem;
        }

        .price-amt {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.2rem;
        }

        .price-sub {
            font-size: 0.75rem;
            color: var(--green);
            margin-bottom: 1.3rem;
        }

        .info-pills {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 1.2rem;
        }

        .ip {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: 10px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ip span {
            font-size: 0.78rem;
            color: var(--text2);
        }

        .ip strong {
            font-size: 0.84rem;
        }

        .sel-btn {
            width: 100%;
            background: var(--grad-primary);
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            display: block;
            text-align: center;
            box-shadow: 0 10px 24px -10px rgba(139, 123, 255, 0.7);
        }

        .sel-btn:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
        }

        .guest-lock {
            width: 100%;
            background: var(--bg4);
            color: var(--text3);
            border: 1px dashed var(--border);
            padding: 12px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .guest-lock:hover {
            border-color: var(--purple);
            color: var(--purple2);
        }

        /* === AUTH FORM DI DALAM MODAL === */
        .auth-tabs {
            display: flex;
            background: var(--bg3);
            border-radius: 10px;
            padding: 4px;
            margin: 0 1.75rem 1.25rem;
        }

        .auth-tab {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 8px;
            background: transparent;
            color: var(--text2);
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
        }

        .auth-tab.active {
            background: var(--grad-primary);
            color: #fff;
        }

        .auth-form {
            display: none;
            padding: 0 1.75rem 1.25rem;
        }

        .auth-form.active {
            display: block;
        }

        .fg {
            margin-bottom: 1rem;
        }

        .fg label {
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text2);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .fg input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--bg);
            color: var(--text);
            font-size: 0.88rem;
            transition: border-color .2s;
            box-sizing: border-box;
            outline: none;
        }

        .fg input:focus {
            border-color: var(--purple);
        }

        .fg input::placeholder {
            color: var(--text3);
        }

        .forgot-row {
            text-align: right;
            margin-top: -0.5rem;
            margin-bottom: 1rem;
        }

        .forgot-row a {
            color: var(--purple2);
            font-size: 0.78rem;
            text-decoration: none;
        }

        .forgot-row a:hover {
            text-decoration: underline;
        }

        .auth-submit {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            background: var(--grad-primary);
            color: #fff;
            font-size: 0.92rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            margin-bottom: 0.75rem;
            box-shadow: 0 8px 20px -9px rgba(139, 123, 255, 0.7);
        }

        .auth-submit:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
        }

        .auth-switch {
            text-align: center;
            font-size: 0.8rem;
            color: var(--text2);
            margin-top: 0.5rem;
        }

        .auth-switch a {
            color: var(--purple2);
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .auth-switch a:hover {
            text-decoration: underline;
        }

        .auth-demo {
            margin-top: 0.8rem;
            padding: 10px 14px;
            background: rgba(124, 111, 224, 0.08);
            border: 1px solid rgba(124, 111, 224, 0.2);
            border-radius: 10px;
            font-size: 0.75rem;
            color: var(--text2);
            text-align: center;
        }

        .auth-demo strong {
            color: var(--purple2);
        }

        .auth-error {
            background: rgba(220, 50, 50, 0.1);
            border: 1px solid rgba(220, 50, 50, 0.3);
            border-radius: 8px;
            padding: 8px 12px;
            margin-bottom: 1rem;
            font-size: 0.8rem;
            color: #f87171;
        }
    </style>
@endpush

@section('content')

    {{-- === MODAL AKSES TERKUNCI (sama persis dengan courses) === --}}
    @guest
        <div class="modal-overlay" id="coachModal" style="z-index:501;">
            <div class="modal-box" style="position:relative;max-width:420px;">
                <button class="modal-close"
                    onclick="document.getElementById('coachModal').classList.remove('open');document.body.style.overflow='';">&times;</button>

                {{-- Konten awal: Akses Terkunci --}}
                <div id="coachLockView">
                    <div class="modal-head" style="text-align:center;">
                        <div style="display:flex;align-items:center;justify-content:center;margin-bottom:0.75rem;">
                            <span style="display:inline-flex;align-items:center;justify-content:center;width:52px;height:52px;border-radius:50%;background:rgba(139,123,255,0.12);border:1px solid rgba(139,123,255,0.25);">
                                <x-cs-icon name="lock" size="22" stroke="1.75" style="color:var(--purple2)" />
                            </span>
                        </div>
                        <div class="modal-logo"><x-cs-logo size="18" /></div>
                        <h3 style="font-size:1.2rem;font-weight:800;margin-bottom:0.3rem;">Akses Terkunci</h3>
                        <p style="font-size:0.82rem;color:var(--text2);">Buat akun gratis dulu yuk untuk langsung pilih paket coaching dan terhubung dengan coach.</p>
                    </div>
                    <div style="padding:1.5rem 1.75rem;display:flex;flex-direction:column;gap:10px;">
                        <button class="btn-full" onclick="showAuthForm('login')">Masuk ke Akun</button>
                        <button onclick="showAuthForm('register')"
                            style="width:100%;padding:11px;border-radius:10px;border:1px solid var(--border);background:transparent;color:var(--text);font-size:0.9rem;font-weight:600;cursor:pointer;">Daftar
                            Gratis &rarr;</button>
                    </div>
                    <div style="text-align:center;padding:0 1.75rem 1.25rem;font-size:0.78rem;color:var(--text3);">&#10003; Gratis &middot; &#10003;
                        Tanpa kartu kredit &middot; &#10003; Akses instan</div>
                </div>

                {{-- Form Login / Register --}}
                <div id="coachAuthView" style="display:none;">
                    <div class="auth-tabs">
                        <button class="auth-tab active" id="tabLogin" onclick="switchAuthTab('login')">Masuk</button>
                        <button class="auth-tab" id="tabRegister" onclick="switchAuthTab('register')">Daftar</button>
                    </div>

                    {{-- Login Form --}}
                    <form id="formCoachLogin" method="POST" action="{{ route('login') }}" class="auth-form"
                        style="padding:0 1.75rem 1.5rem;">
                        @csrf
                        <input type="hidden" name="redirect_to" value="{{ request()->fullUrl() }}">
                        <div id="loginError" class="auth-error" style="display:none;"></div>

                        <div class="form-g">
                            <label>Email</label>
                            <input type="email" name="email" class="form-ctrl" placeholder="nama@email.com" required>
                        </div>
                        <div class="form-g">
                            <label>Password</label>
                            <input type="password" name="password" class="form-ctrl" placeholder="••••••••" required>
                        </div>
                        <div class="forgot-row">
                            <a href="{{ route('password.request') }}">Lupa Password?</a>
                        </div>
                        <button type="submit" class="auth-submit">Masuk ke Akun</button>
                        <div class="auth-switch">
                            Belum punya akun? <a onclick="switchAuthTab('register')">Daftar Akun</a>
                        </div>
                    </form>

                    {{-- Register Form --}}
                    <form id="formCoachRegister" method="POST" action="{{ route('register') }}" class="auth-form"
                        style="display:none;padding:0 1.75rem 1.5rem;">
                        @csrf
                        <input type="hidden" name="redirect_to" value="{{ request()->fullUrl() }}">
                        <div id="registerError" class="auth-error" style="display:none;"></div>

                        <div class="form-g">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" class="form-ctrl" placeholder="Nama kamu" required>
                        </div>
                        <div class="form-g">
                            <label>Email</label>
                            <input type="email" name="email" class="form-ctrl" placeholder="nama@email.com" required>
                        </div>
                        <div class="form-g">
                            <label>Password</label>
                            <input type="password" name="password" class="form-ctrl" placeholder="Minimal 8 karakter"
                                required>
                        </div>
                        <div class="form-g">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-ctrl" placeholder="Ulangi password"
                                required>
                        </div>
                        <button type="submit" class="auth-submit">Daftar Akun Baru</button>
                        <div class="auth-switch">
                            Sudah punya akun? <a onclick="switchAuthTab('login')">Masuk</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endguest

    <div class="coaching-wrap">
        {{-- Flash Messages --}}
        @if(session('error'))
            <div style="background:rgba(255,80,80,0.1);border:1px solid rgba(255,80,80,0.3);border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.5rem;font-size:0.875rem;color:#ff5f5f;display:flex;align-items:flex-start;gap:10px;">
                <span style="flex-shrink:0;font-size:1.1rem;">⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if(session('success'))
            <div style="background:rgba(0,212,170,0.1);border:1px solid rgba(0,212,170,0.3);border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.5rem;font-size:0.875rem;color:var(--green);display:flex;align-items:flex-start;gap:10px;">
                <span style="flex-shrink:0;font-size:1.1rem;">✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        <div style="text-align:center;margin-bottom:2rem;">
            <div
                style="display:inline-block;background:rgba(124,111,224,0.15);color:var(--purple2);padding:4px 12px;border-radius:50px;font-size:0.72rem;font-weight:700;margin-bottom:0.75rem;">
                COACHING</div>
            <h2 style="font-size:clamp(1.5rem,3vw,2.2rem);font-weight:700;margin-bottom:0.6rem;">Pilih Program Coaching CS2
                Kamu</h2>
            <p style="color:var(--text2);font-size:0.9rem;">Mentoring langsung dari pelatih aktif di skena kompetitif CS2 — fokus ke eksekusi & gameplay nyata.</p>
                @guest
                    <div
                        style="margin-top:1rem;background:rgba(124,111,224,0.08);border:1px solid rgba(124,111,224,0.25);border-radius:12px;padding:10px 18px;display:inline-flex;align-items:center;gap:8px;font-size:0.82rem;color:var(--purple2);">
                        <x-cs-icon name="lock" size="13" stroke="2" /> Login untuk membeli paket coaching
                    </div>
                @endguest
        </div>

        <div class="tabs-wrapper">
            <div class="tab-btns">
                <button class="tab-btn active" onclick="swTab('textual',this)">Textual Review</button>
                <button class="tab-btn" onclick="swTab('call',this)">Panggil Pelatih</button>
                <button class="tab-btn" onclick="swTab('demo',this)">Demo Review</button>
            </div>
                @php
                $services = [
                    'textual' => [
                        'icon' => 'file-text',
                        'title' => 'Textual Review',
                        'desc' =>
                            'Sesi evaluasi 1 jam via voice call plus rangkuman poin penting tertulis. Bebas bedah role, positioning, utilitas, hingga kebiasaan kecil yang bikin kamu kepentok rank.',
                        'harga' => 'Rp 100.000',
                        'sub' => '✦ Langsung ditinjau oleh coach aktif',
                        'p1_icon' => 'zap',
                        'p1l' => 'Coach Masuk',
                        'p1v' => '< 5 Menit',
                        'p2_icon' => 'clock',
                        'p2l' => 'Durasi Sesi',
                        'p2v' => '1 Jam',
                        'param' => 'Textual+Review',
                    ],
                    'call' => [
                        'icon' => 'phone',
                        'title' => 'Panggil Pelatih',
                        'desc' =>
                            'Tanya jawab dan bedah taktik secara langsung 1-on-1 via Discord. Materi disesuaikan persis dengan kendala utama yang sering bikin kamu kalah clutch.',
                        'harga' => 'Rp 250.000',
                        'sub' => '✦ Sesi 1-on-1 via Discord',
                        'p1_icon' => 'zap',
                        'p1l' => 'Coach Masuk',
                        'p1v' => '< 5 Menit',
                        'p2_icon' => 'users',
                        'p2l' => 'Platform',
                        'p2v' => 'Discord',
                        'param' => 'Panggil+Pelatih',
                    ],
                    'demo' => [
                        'icon' => 'film',
                        'title' => 'Demo Review',
                        'desc' =>
                            'Kirimkan demo match terbaik atau terburukmu. Coach bakal analisis setiap ronde dan kirim breakdown mendalam tentang crosshair placement, rotasi, dan timing.',
                        'harga' => 'Rp 300.000',
                        'sub' => '✦ Laporan pembahasan lengkap',
                        'p1_icon' => 'zap',
                        'p1l' => 'Analyst Masuk',
                        'p1v' => '< 5 Menit',
                        'p2_icon' => 'clock',
                        'p2l' => 'Waktu Review',
                        'p2v' => '24–48 Jam',
                        'param' => 'Demo+Review',
                    ],
                ];
            @endphp

            @foreach ($services as $key => $s)
                <div class="tab-c {{ $key === 'textual' ? 'active' : '' }}" id="tc-{{ $key }}">
                    <div class="svc-card">
                        <div class="svc-ic">
                            <x-cs-icon :name="$s['icon']" size="20" stroke="2" />
                        </div>
                        <h3>{{ $s['title'] }}</h3>
                        <p>{{ $s['desc'] }}</p>
                    </div>
                    <div class="price-box">
                        <h4
                            style="font-size:0.72rem;font-weight:700;color:var(--text2);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.9rem;">
                            Harga Layanan</h4>
                        <div class="price-amt">{{ $s['harga'] }}</div>
                        <div class="price-sub">{{ $s['sub'] }}</div>
                        <div class="info-pills">
                            <div class="ip">
                                <x-cs-icon :name="$s['p1_icon']" size="15" stroke="2" style="color:var(--purple2);flex-shrink:0;" />
                                <div><span>{{ $s['p1l'] }}</span><br><strong>{{ $s['p1v'] }}</strong></div>
                            </div>
                            <div class="ip">
                                <x-cs-icon :name="$s['p2_icon']" size="15" stroke="2" style="color:var(--purple2);flex-shrink:0;" />
                                <div><span>{{ $s['p2l'] }}</span><br><strong>{{ $s['p2v'] }}</strong></div>
                            </div>
                        </div>
                        @auth
                            @if(auth()->user()->hasPendingCoaching())
                                <div style="background:rgba(255,140,66,0.1);border:1px solid rgba(255,140,66,0.35);border-radius:10px;padding:12px 14px;font-size:0.82rem;line-height:1.5;">
                                    <div style="font-weight:700;color:var(--orange);margin-bottom:4px;">⏳ Sesi Masih Aktif</div>
                                    <div style="color:var(--text2);">Kamu masih punya sesi coaching yang sedang berjalan atau menunggu verifikasi. Selesaikan sesi tersebut sebelum membeli paket baru.</div>
                                    <a href="{{ route('payment.pending') }}" style="display:inline-flex;align-items:center;gap:5px;margin-top:10px;background:rgba(255,140,66,0.15);color:var(--orange);padding:6px 12px;border-radius:7px;font-size:0.78rem;font-weight:700;">📋 Lihat Status</a>
                                </div>
                            @else
                                <a href="{{ route('payment') }}?layanan={{ $s['param'] }}&harga={{ urlencode($s['harga']) }}"
                                    class="sel-btn" style="display:inline-flex;align-items:center;justify-content:center;gap:8px;">
                                    <x-cs-icon name="zap" size="15" stroke="2" /> Pilih Paket Ini
                                </a>
                            @endif
                        @else
                            <button class="guest-lock" onclick="openCoachModal()">
                                <x-cs-icon name="lock" size="15" stroke="2" /> Login dulu untuk beli
                            </button>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function swTab(id, btn) {
            document.querySelectorAll('.tab-c').forEach(function(t) {
                t.classList.remove('active');
            });
            document.querySelectorAll('.tab-btn').forEach(function(b) {
                b.classList.remove('active');
            });
            document.getElementById('tc-' + id).classList.add('active');
            btn.classList.add('active');
        }

        function openCoachModal() {
            var m = document.getElementById('coachModal');
            document.getElementById('coachLockView').style.display = 'block';
            document.getElementById('coachAuthView').style.display = 'none';
            m.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function showAuthForm(type) {
            document.getElementById('coachLockView').style.display = 'none';
            document.getElementById('coachAuthView').style.display = 'block';
            switchCoachTab(type);
        }

        function switchCoachTab(tab) {
            document.querySelectorAll('.auth-tab').forEach(function(b) {
                b.classList.remove('active');
            });
            document.querySelectorAll('.auth-form').forEach(function(f) {
                f.classList.remove('active');
            });
            if (tab === 'register') {
                document.getElementById('cTabRegister').classList.add('active');
                document.getElementById('cFormRegister').classList.add('active');
            } else {
                document.getElementById('cTabLogin').classList.add('active');
                document.getElementById('cFormLogin').classList.add('active');
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                var m = document.getElementById('coachModal');
                if (m && m.classList.contains('open')) {
                    m.classList.remove('open');
                    document.body.style.overflow = '';
                }
            }
        });

        @auth
        @else
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    openCoachModal();
                }, 500);
            });
        @endauth
    </script>
@endpush
