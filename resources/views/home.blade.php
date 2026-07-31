@extends('layouts.app')
@section('title', 'Home')

@push('styles')
    <link rel="stylesheet" href="/css/home.css" />
@endpush

@section('content')
    <div class="hero-bg">
        <div class="hero">
            <div class="hero-badge">
                <x-cs-icon name="trophy" size="13" stroke="2" /> Platform Coaching CS2 Indonesia
            </div>
            <h1 class="hero-title">Naik Rank CS2 Lebih Cepat,<br><em>Dibimbing Pro Player</em>
            </h1>
            <p class="hero-desc">Asah cara mainmu lewat modul interaktif, kuis praktis, dan sesi bedah taktik 1-on-1 bareng coach kompetitif. Gameplay makin rapi, rank auto naik.</p>
            <div class="hero-cta">
                <a href="{{ route('coaching') }}" class="btn-hero-primary">Mulai Sekarang</a>
                <a href="{{ route('courses') }}" class="btn-hero-secondary">Lihat Kursus</a>
            </div>
            <div class="hero-stats">
                <div>
                    <div class="stat-item-val">
                        {{ $stats['total_players'] > 999
                            ? number_format($stats['total_players'] / 1000, 1) . 'K+'
                            : $stats['total_players'] }}
                    </div>
                    <div class="stat-item-label">Pemain Terdaftar</div>
                </div>
                <div>
                    <div class="stat-item-val">{{ $stats['total_completions'] }}+</div>
                    <div class="stat-item-label">Kursus Diselesaikan</div>
                </div>
                <div>
                    <div class="stat-item-val">{{ $stats['total_courses'] }}</div>
                    <div class="stat-item-label">Kursus Tersedia</div>
                </div>
                <div>
                    <div class="stat-item-val">{{ $stats['total_coaching'] }}+</div>
                    <div class="stat-item-label">Sesi Coaching</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Skill Topics Bar --}}
    <div class="topics-bar">
        <p class="topics-bar-label">Topik Gameplay yang Bakal Kamu Kuasai</p>
        <div class="topics-list">
            @foreach([
                ['target',    'Aim Training'],
                ['map',       'Map Knowledge'],
                ['coins',     'Economy & Buy'],
                ['map-pin',   'Positioning'],
                ['lightbulb', 'Game Sense'],
                ['activity',  'Spray Control'],
                ['film',      'Demo Review'],
                ['trophy',    'Rank Strategy'],
            ] as [$icon, $label])
                <span class="topic-chip">
                    <x-cs-icon :name="$icon" size="13" stroke="1.75" />
                    {{ $label }}
                </span>
            @endforeach
        </div>
    </div>

    {{-- Cara Kerja --}}
    <div class="how-bg">
        <section class="how-section">
            <div class="how-head">
                <div class="how-badge">CARA KERJA</div>
                <h2 class="how-title">Bagaimana CS2 Academy Bekerja?</h2>
                <p class="how-sub">3 Langkah simpel buat mulai konsultasi dan tingkatkan cara mainmu</p>
            </div>

            <div class="how-grid">
                {{-- Step 1: Pilih Layanan --}}
                <div class="how-card">
                    <span class="how-num how-num--purple">1</span>
                    <h3>Pilih Layanan</h3>
                    <p>Pilih paket coaching yang paling cocok buat gaya mainmu — dari catatan review sampai sesi 1-on-1.</p>
                    <div class="how-mock">
                        <div class="mock-tabs">
                            <span class="mock-tab active">Coaching</span>
                            <span class="mock-tab">Review</span>
                            <span class="mock-tab">Demo</span>
                        </div>
                        <div class="mock-slider-label"><span>Durasi Sesi</span><strong>3 <span class="mock-dim">/ 5 jam</span></strong></div>
                        <div class="mock-track">
                            <div class="mock-fill" style="width:60%"></div>
                            <div class="mock-thumb" style="left:60%"></div>
                        </div>
                        <div class="mock-row"><span class="mock-bar"></span><span class="mock-toggle on"></span></div>
                        <div class="mock-row"><span class="mock-bar short"></span><span class="mock-toggle"></span></div>
                        <button class="mock-btn" tabindex="-1">Pilih Paket</button>
                    </div>
                </div>

                {{-- Step 2: Proses Pembayaran --}}
                <div class="how-card">
                    <span class="how-num how-num--green">2</span>
                    <h3>Proses Pembayaran</h3>
                    <p>Bayar via GoPay, OVO, atau BCA. Konfirmasi instan, langsung lanjut tanpa ribet.</p>
                    <div class="how-mock how-mock--pay">
                        <div class="pay-chip" style="--c:#00d4aa;">💚 GoPay</div>
                        <div class="pay-orb">✓</div>
                        <div class="pay-chip" style="--c:#9d93f0;">💜 OVO</div>
                        <div class="pay-chip" style="--c:#4fc3f7;">🏦 BCA VA</div>
                    </div>
                </div>

                {{-- Step 3: Dapat Coach & Mulai --}}
                <div class="how-card">
                    <span class="how-num how-num--blue">3</span>
                    <h3>Dapat Coach & Mulai!</h3>
                    <p>Coach siap terhubung di Discord buat bimbing kamu lewat voice call maupun catatan review.</p>
                    <div class="how-mock how-mock--chat">
                        <div class="chat-head"><span class="chat-dot"></span> Coach Rafi <span class="chat-online">● Online</span></div>
                        <div class="chat-bubble them">
                            <span class="mock-bar"></span>
                            <span class="mock-bar short"></span>
                        </div>
                        <div class="chat-bubble me"><span class="mock-bar"></span></div>
                        <div class="chat-input"><span class="mock-bar tiny"></span><span class="chat-send">➤</span></div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- CTA --}}
    <div class="cta-wrap">
        <div class="cta-box">
            <div class="cta-icon-wrap">
                <span class="cta-icon">
                    <x-cs-icon name="rocket" size="26" stroke="1.5" />
                </span>
            </div>
            <h2 class="cta-title">Siap Naik Rank?</h2>
            <p class="cta-desc">Ratusan player udah ngerasain bedanya. Sekarang giliran kamu pembuktian di Matchmaking & Faceit.</p>
            <a href="{{ route('coaching') }}" class="btn-cta">
                <x-cs-icon name="zap" size="16" stroke="2" /> Mulai Coaching Sekarang
            </a>
        </div>
    </div>
@endsection
