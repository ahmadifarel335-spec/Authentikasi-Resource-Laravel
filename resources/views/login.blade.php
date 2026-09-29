@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
    <div class="auth-form-body">
        <p class="auth-eyebrow">AKSES AKUN</p>
        <h1 class="auth-title">Masuk</h1>
        <p class="auth-description">Masukkan email dan kata sandi akun Anda.</p>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" autocomplete="email" required autofocus>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Kata sandi</label>
                <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" autocomplete="current-password" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                <div class="form-check">
                    <input id="remember" name="remember" type="checkbox" value="1" class="form-check-input">
                    <label for="remember" class="form-check-label">Ingat saya</label>
                </div>
                <a href="{{ route('home') }}" class="auth-secondary-link">Beranda</a>
            </div>
            <button type="submit" class="btn btn-primary w-100 auth-submit">Masuk ke dashboard</button>
        </form>

        <p class="auth-register-prompt">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </p>
    </div>
@endsection
