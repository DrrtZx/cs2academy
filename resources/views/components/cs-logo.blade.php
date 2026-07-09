{{--
    CS2 Academy — Redesigned SVG Logo Component

    Design concept (inspired by user reference, improved):
    · Precision crosshair ring with 4 tick marks — sharp, tactical
    · Bold diagonal rising arrow (gradient purple→cyan) cutting through the crosshair
      represents "leveling up" / rank improvement — the Academy's core promise
    · Inner C-arc subtly hints at "CS" branding
    · White crosshair + gradient arrow = clear visual hierarchy on dark backgrounds

    Usage:
    <x-cs-logo />                       — default (nav, 30px mark)
    <x-cs-logo size="22" />             — custom size
    <x-cs-logo :showText="false" />     — mark only (no text)
    <x-cs-logo textClass="..." />       — extra class on text span
--}}
@props([
    'size'      => 30,
    'showText'  => true,
    'textClass' => '',
    'class'     => '',
])

@php
    // Unique IDs to avoid SVG defs collisions when logo appears multiple times
    static $lc = 0;
    $lc++;
    $gArr = 'csA' . $lc;   // arrow gradient
    $gRng = 'csR' . $lc;   // ring gradient (subtle)
    $clip = 'csC' . $lc;   // clip path
@endphp

<span style="display:inline-flex;align-items:center;gap:9px;text-decoration:none;" class="{{ $class }}">

    {{-- ── LOGO MARK ── --}}
    {{-- viewBox 40×40, center (20,20) --}}
    <svg
        width="{{ $size }}"
        height="{{ $size }}"
        viewBox="0 0 40 40"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
        focusable="false"
        style="flex-shrink:0;overflow:visible;"
    >
        <defs>
            {{-- Gradient for the rising arrow --}}
            <linearGradient id="{{ $gArr }}" x1="8" y1="34" x2="34" y2="8" gradientUnits="userSpaceOnUse">
                <stop offset="0%"   stop-color="#7c6fe0"/>
                <stop offset="55%"  stop-color="#4fc3f7"/>
                <stop offset="100%" stop-color="#3fd8ff"/>
            </linearGradient>

            {{-- Gradient for the outer ring (subtle top-left cool, bottom-right warm) --}}
            <linearGradient id="{{ $gRng }}" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%"   stop-color="rgba(255,255,255,0.95)"/>
                <stop offset="100%" stop-color="rgba(220,220,255,0.75)"/>
            </linearGradient>
        </defs>

        {{-- ── CROSSHAIR OUTER RING ── --}}
        {{-- Radius 15, leaving visual gaps where the arrow cuts through --}}
        <circle cx="20" cy="20" r="15"
                stroke="url(#{{ $gRng }})"
                stroke-width="1.8"
                stroke-dasharray="10.8 3.2 10.8 3.2 10.8 3.2 10.8 3.2"
                stroke-dashoffset="-8.5"
                stroke-linecap="round"/>

        {{-- ── 4 TICK MARKS (outward extensions of the crosshair) ── --}}
        {{-- Top --}}
        <line x1="20" y1="1.5" x2="20" y2="5.5"
              stroke="rgba(255,255,255,0.9)" stroke-width="2.2" stroke-linecap="round"/>
        {{-- Bottom --}}
        <line x1="20" y1="34.5" x2="20" y2="38.5"
              stroke="rgba(255,255,255,0.9)" stroke-width="2.2" stroke-linecap="round"/>
        {{-- Left --}}
        <line x1="1.5" y1="20" x2="5.5" y2="20"
              stroke="rgba(255,255,255,0.9)" stroke-width="2.2" stroke-linecap="round"/>
        {{-- Right --}}
        <line x1="34.5" y1="20" x2="38.5" y2="20"
              stroke="rgba(255,255,255,0.9)" stroke-width="2.2" stroke-linecap="round"/>

        {{-- ── INNER PRECISION RING + CENTER DOT ── --}}
        <circle cx="20" cy="20" r="5.5"
                stroke="rgba(255,255,255,0.4)"
                stroke-width="1.3"/>
        <circle cx="20" cy="20" r="2"
                fill="rgba(255,255,255,0.55)"/>

        {{-- ── RISING DIAGONAL ARROW ── --}}
        {{-- Shaft: from lower-left (11,30) to near the arrowhead base --}}
        <line x1="11" y1="30" x2="24.5" y2="16.5"
              stroke="url(#{{ $gArr }})"
              stroke-width="2.8"
              stroke-linecap="round"/>

        {{-- Arrowhead: filled triangle pointing upper-right at ~45° --}}
        {{--
            Tip:   (33, 8)
            Wing1: (25, 12)  ← left of direction
            Wing2: (29, 18)  ← right of direction
            Creates a sharp, clean arrowhead
        --}}
        <polygon points="33,8 25,12.5 29.5,18"
                 fill="url(#{{ $gArr }})"/>
    </svg>

    {{-- ── TEXT LOCKUP ── --}}
    @if($showText)
        <span
            style="font-weight:800;font-size:1.15rem;letter-spacing:-0.3px;line-height:1;color:#fff;"
            class="{{ $textClass }}"
        ><span style="background:linear-gradient(120deg,#a29bfe,#3fd8ff);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;font-weight:900;">CS2</span><span style="color:rgba(255,255,255,0.92);font-weight:700;">Academy</span></span>
    @endif

</span>
