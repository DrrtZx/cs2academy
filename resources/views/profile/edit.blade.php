@extends('layouts.app')
@section('title', 'Profile Settings')

@push('styles')
<style>
.pw { max-width: 680px; margin: 0 auto; padding: 3rem 2rem; }
.pw h2 { font-size: 1.4rem; font-weight: 800; margin-bottom: 0.3rem; color: var(--text); }
.pw .sub { color: var(--text2); font-size: 0.875rem; margin-bottom: 2rem; }

.card { background: var(--bg2); border: 1px solid var(--border); border-radius: 16px; padding: 24px 26px; margin-bottom: 20px; }
.card-title { font-size: 13px; font-weight: 700; color: var(--text2); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }

/* Avatar header */
.profile-header { display: flex; align-items: center; gap: 18px; margin-bottom: 2rem; background: var(--bg2); border: 1px solid var(--border); border-radius: 16px; padding: 20px 24px; }
.avatar-lg { width: 72px; height: 72px; border-radius: 50%; background: linear-gradient(135deg, var(--purple), var(--cyan)); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 800; color: #fff; flex-shrink: 0; overflow: hidden; }
.avatar-lg img { width: 100%; height: 100%; object-fit: cover; }
.profile-info { flex: 1; min-width: 0; }
.profile-name { font-size: 1.1rem; font-weight: 800; color: var(--text); }
.profile-email { font-size: 0.82rem; color: var(--text2); margin-top: 2px; }

.field { margin-bottom: 1rem; }
.field:last-child { margin-bottom: 0; }
.field label { display: block; font-size: 11.5px; font-weight: 700; color: var(--text2); text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 6px; }
.field input { width: 100%; background: var(--bg3); border: 1px solid var(--border); border-radius: 10px; padding: 11px 14px; color: var(--text); font-size: 14px; font-family: inherit; outline: none; }
.field input:focus { border-color: var(--purple); }
.field-hint { font-size: 11px; color: var(--text3); margin-top: 4px; }

.btn-primary { background: var(--grad-primary); border: none; border-radius: 10px; padding: 12px 24px; color: #fff; font-weight: 700; font-size: 14px; cursor: pointer; font-family: inherit; width: 100%; }
.btn-primary:hover { filter: brightness(1.08); }
.btn-ghost { background: var(--bg3); border: 1px solid var(--border); border-radius: 10px; padding: 8px 16px; color: var(--text2); font-weight: 600; font-size: 12px; cursor: pointer; font-family: inherit; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; }
.btn-ghost:hover { border-color: var(--purple); color: var(--text); }

.alert-success { background: rgba(43,230,186,0.1); border: 1px solid rgba(43,230,186,0.3); border-radius: 10px; padding: 0.9rem 1.25rem; margin-bottom: 1.25rem; font-size: 0.875rem; color: var(--green); }
</style>
@endpush

@section('content')
<div class="pw">

  <h2>Profile Settings</h2>
  <p class="sub">Kelola informasi akun dan pengaturan keamanan kamu.</p>

  @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif

  {{-- Profile Header --}}
  <div class="profile-header">
    <div class="avatar-lg" id="avatar-preview">
      @if(auth()->user()->avatar)
        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="avatar">
      @else
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
      @endif
    </div>
    <div class="profile-info">
      <div class="profile-name">{{ auth()->user()->name }}</div>
      <div class="profile-email">{{ auth()->user()->email }}</div>
      @if(auth()->user()->discord_id)
        <div style="font-size:0.78rem;color:var(--purple2);margin-top:4px;">Discord: {{ auth()->user()->discord_id }}</div>
      @endif
    </div>
  </div>

  {{-- Info Akun --}}
  <div class="card">
    <div class="card-title">Info Akun</div>
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
      @csrf @method('PATCH')

      <div class="field">
        <label>Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required>
        @error('name') <div style="color:var(--red);font-size:0.75rem;margin-top:4px;">{{ $message }}</div> @enderror
      </div>

      <div class="field">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
        @error('email') <div style="color:var(--red);font-size:0.75rem;margin-top:4px;">{{ $message }}</div> @enderror
      </div>

      <div class="field">
        <label>Foto Profile</label>
        <input type="file" name="avatar" accept="image/*" style="font-size:13px;color:var(--text2);">
        <div class="field-hint">JPG/PNG, maksimal 2MB.</div>
        @error('avatar') <div style="background:rgba(255,114,114,0.1);border:1px solid rgba(255,114,114,0.3);border-radius:8px;padding:10px 14px;margin-top:8px;font-size:0.8rem;color:var(--red);font-weight:600;">{{ $message }}</div> @enderror
      </div>

      <div class="field">
        <label>Discord ID</label>
        <input type="text" name="discord_id" value="{{ old('discord_id', auth()->user()->discord_id) }}" placeholder="username#0000">
        <div class="field-hint">Untuk sesi Panggil Pelatih — coach akan menghubungi kamu via Discord.</div>
        @error('discord_id') <div style="color:var(--red);font-size:0.75rem;margin-top:4px;">{{ $message }}</div> @enderror
      </div>

      <button type="submit" class="btn-primary" style="margin-top:0.5rem;">Simpan Perubahan</button>
    </form>
  </div>

  {{-- Keamanan --}}
  <div class="card">
    <div class="card-title">Keamanan</div>
    <form method="POST" action="{{ route('profile.password') }}">
      @csrf @method('PUT')

      <div class="field">
        <label>Password Saat Ini</label>
        <input type="password" name="current_password" required>
        @error('current_password') <div style="color:var(--red);font-size:0.75rem;margin-top:4px;">{{ $message }}</div> @enderror
      </div>

      <div class="field">
        <label>Password Baru</label>
        <input type="password" name="password" required>
        @error('password') <div style="color:var(--red);font-size:0.75rem;margin-top:4px;">{{ $message }}</div> @enderror
      </div>

      <div class="field">
        <label>Konfirmasi Password Baru</label>
        <input type="password" name="password_confirmation" required>
      </div>

      <button type="submit" class="btn-primary" style="margin-top:0.5rem;">Simpan Perubahan</button>
    </form>
  </div>

</div>
@endsection
