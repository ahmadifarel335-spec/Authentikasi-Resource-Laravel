<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | POS Toko</title>
    <link rel="stylesheet" href="{{ asset('teamplate/css/adminlte.min.css') }}">
    @stack('styles')
</head>
<body class="bg-body-tertiary">
    <nav class="navbar navbar-expand bg-white border-bottom px-3 px-md-4">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand fw-bold text-primary">POS Toko</a>
        <div class="d-flex flex-wrap align-items-center gap-1 ms-2">
            <a href="{{ route('admin.dashboard') }}" class="nav-link px-2">Dashboard</a>
            <a href="{{ route('admin.produk.index') }}" class="nav-link px-2">Produk</a>
        </div>
        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="text-secondary d-none d-sm-inline">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary btn-sm">Keluar</button>
            </form>
        </div>
    </nav>
    <main class="container-fluid px-3 px-md-4 py-4">
        @if (session('status'))
            <div class="alert alert-success" role="status">{{ session('status') }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>
