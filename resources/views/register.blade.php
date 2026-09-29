@extends('layouts.guest')

@section('title', 'Daftar')

@section('content')
    <div class="auth-form-body">
        <p class="auth-eyebrow">AKSES AKUN</p>
        <h1 class="auth-title">Daftar</h1>
        <p class="auth-description">Buat akun untuk masuk ke POS Toko.</p>

        <form method="POST" action="{{ route('register.store') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" autocomplete="name" required autofocus>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" autocomplete="email" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Kata sandi</label>
                <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Ulangi kata sandi</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 auth-submit">Daftar</button>
        </form>

        <p class="text-center text-secondary mt-4 mb-0">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
        </p>
    </div>
@endsection
