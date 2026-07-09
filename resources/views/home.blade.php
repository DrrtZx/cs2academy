@extends('layouts.app')
@section('title', 'Home')

@push('styles')
    <link rel="stylesheet" href="/css/home.css" />
@endpush

@section('content')
    <div class="hero-bg">
        <div class="hero">
            <div class="hero-badge">
                <x-cs-icon name="trophy" size="13" stroke="2" /> Platform CS2 #1 di Indonesia
            </div>
            <h1 class="hero-title">Kuasai CS2
                dengan<br><em>Pelatihan Eksklusif</em>
            </h1>
            <p class="hero-desc">Platform edukasi CS2 terlengkap dengan pembelajaran interaktif, kuis praktikal, dan
                coaching dari pro player. Naik rank lebih cepat.</p>
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
        <p class="topics-bar-label">Materi yang Kami Ajarkan</p>
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
                <p class="how-sub">Cukup 3 langkah untuk mulai berkembang bareng coach profesional</p>
            </div>

            <div class="how-grid">
                {{-- Step 1: Pilih Layanan --}}
                <div class="how-card">
                    <span class="how-num how-num--purple">1</span>
                    <h3>Pilih Layanan</h3>
                    <p>Pilih paket coaching yang sesuai level dan kebutuhanmu — dari textual review sampai sesi 1-on-1.</p>
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
                    <p>Coach profesional langsung ditugaskan dan siap bantu kamu lewat chat maupun voice call.</p>
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
            <p class="cta-desc">Bergabung dengan ribuan pemain yang sudah meningkatkan skill mereka.</p>
            <a href="{{ route('coaching') }}" class="btn-cta">
                <x-cs-icon name="zap" size="16" stroke="2" /> Mulai Coaching Sekarang
            </a>
        </div>
    </div>
@endsection
