@extends('layouts.app')
@section('title', 'Coaching')

@push('styles')
    <style>
        .coaching-wrap {
            max-width: 1060px;
            margin: 0 auto;
            padding: 4rem 2rem;
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
            width: 42px;
            height: 42px;
            background: rgba(124, 111, 224, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.9rem;
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
                        <p style="font-size:0.82rem;color:var(--text2);">Login atau daftar gratis untuk mengakses seluruh materi
                            coaching CS2.</p>
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

                {{-- Konten form auth (tersembunyi awalnya) --}}
                <div id="coachAuthView" style="display:none;">
                    <div class="auth-tabs">
                        <button class="auth-tab active" id="cTabLogin" onclick="switchCoachTab('login')">Masuk</button>
                        <button class="auth-tab" id="cTabRegister" onclick="switchCoachTab('register')">Daftar Gratis</button>
                    </div>

                    {{-- LOGIN --}}
                    <div class="auth-form active" id="cFormLogin">
                        <div style="text-align:center;margin-bottom:1.2rem;">
                            <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:0.3rem;">Selamat Datang 😊</h3>
                            <p style="color:var(--text2);font-size:0.82rem;">Masuk ke akun CS2Academy kamu</p>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="fg">
                                <label for="c-email">Email</label>
                                <input type="email" name="email" id="c-email" placeholder="email@kamu.com"
                                    value="{{ old('email') }}" required>
                            </div>
                            <div class="fg">
                                <label for="c-password">Password</label>
                                <input type="password" name="password" id="c-password" placeholder="Password kamu" required>
                            </div>

                            <button type="submit" class="auth-submit">Masuk →</button>
                        </form>
                        <div class="auth-switch">Belum punya akun? <a onclick="switchCoachTab('register')">Daftar Gratis</a>
                        </div>
                        <div class="auth-demo">Demo: <strong>demo@cs2.id</strong> / <strong>Demo1234!</strong></div>
                    </div>

                    {{-- REGISTER --}}
                    <div class="auth-form" id="cFormRegister">
                        <div style="text-align:center;margin-bottom:1.2rem;">
                            <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:0.3rem;">Buat Akun Baru</h3>
                            <p style="color:var(--text2);font-size:0.82rem;">Gratis selamanya · Mulai belajar hari ini</p>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="fg">
                                <label for="c-name">Nama Lengkap</label>
                                <input type="text" name="name" id="c-name" placeholder="Nama kamu"
                                    value="{{ old('name') }}" required>
                            </div>
                            <div class="fg">
                                <label for="c-reg-email">Email</label>
                                <input type="email" name="email" id="c-reg-email" placeholder="email@kamu.com"
                                    value="{{ old('email') }}" required>
                            </div>
                            <div class="fg">
                                <label for="c-reg-pw">Password</label>
                                <input type="password" name="password" id="c-reg-pw" placeholder="Minimal 8 karakter" required>
                            </div>
                            <div class="fg">
                                <label for="c-reg-pwc">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="c-reg-pwc" placeholder="Ulangi password"
                                    required>
                            </div>
                            <button type="submit" class="auth-submit">Buat Akun →</button>
                        </form>
                        <div class="auth-switch">Sudah punya akun? <a onclick="switchCoachTab('login')">Masuk</a></div>
                    </div>
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
            <p style="color:var(--text2);font-size:0.9rem;">Langsung ditangani coach yang udah main di level kompetitif — bukan teori doang</p>
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
                        'icon' => 'T',
                        'style' => 'font-size:.9rem;font-weight:900;color:var(--purple2);',
                        'title' => 'Textual Review',
                        'desc' =>
                            'Ngobrol 1 jam via voice call sama coach, terus kamu dapet catatan tertulis dari hasil sesinya. Bisa ngomongin apa aja — role, positioning, economy, mindset, sampai kebiasaan yang bikin kamu stuck di rank sekarang.',
                        'harga' => 'Rp 100.000',
                        'sub' => '✦ Langsung ditinjau oleh coach aktif',
                        'p1' => '⚡',
                        'p1l' => 'Coach Masuk',
                        'p1v' => '< 5 Menit',
                        'p2' => '🕐',
                        'p2l' => 'Durasi Sesi',
                        'p2v' => '1 Jam',
                        'param' => 'Textual+Review',
                    ],
                    'call' => [
                        'icon' => '📞',
                        'style' => '',
                        'title' => 'Panggil Pelatih',
                        'desc' =>
                            'Voice call langsung sama coach CS2. Tanya-tanya, bahas strategi, atau minta review gameplay kamu secara langsung. Coachnya nyesuain materi sama level dan masalah spesifik yang lagi kamu hadapi.',
                        'harga' => 'Rp 250.000',
                        'sub' => '✦ Sesi 1-on-1 via Discord',
                        'p1' => '⚡',
                        'p1l' => 'Coach Masuk',
                        'p1v' => '< 5 Menit',
                        'p2' => '🎙',
                        'p2l' => 'Platform',
                        'p2v' => 'Discord',
                        'param' => 'Panggil+Pelatih',
                    ],
                    'demo' => [
                        'icon' => '🎬',
                        'style' => '',
                        'title' => 'Demo Review',
                        'desc' =>
                            'Upload demo game kamu, nanti coach yang nonton dan bedah semuanya. Kamu bakal dapet laporan yang isinya: momen bagus yang perlu dikembangin, kesalahan yang sering muncul, dan tips konkret buat naik rank lebih cepat.',
                        'harga' => 'Rp 300.000',
                        'sub' => '✦ Laporan pembahasan lengkap',
                        'p1' => '⚡',
                        'p1l' => 'Analyst Masuk',
                        'p1v' => '< 5 Menit',
                        'p2' => '🕐',
                        'p2l' => 'Waktu Review',
                        'p2v' => '24–48 Jam',
                        'param' => 'Demo+Review',
                    ],
                ];
            @endphp

            @foreach ($services as $key => $s)
                <div class="tab-c {{ $key === 'textual' ? 'active' : '' }}" id="tc-{{ $key }}">
                    <div class="svc-card">
                        <div class="svc-ic" style="{{ $s['style'] }}">{{ $s['icon'] }}</div>
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
                            <div class="ip">{{ $s['p1'] }}<div>
                                    <span>{{ $s['p1l'] }}</span><br><strong>{{ $s['p1v'] }}</strong></div>
                            </div>
                            <div class="ip">{{ $s['p2'] }}<div>
                                    <span>{{ $s['p2l'] }}</span><br><strong>{{ $s['p2v'] }}</strong></div>
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
