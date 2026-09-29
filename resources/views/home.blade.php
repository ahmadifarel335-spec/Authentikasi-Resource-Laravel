<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS Toko</title>
    <link rel="stylesheet" href="{{ asset('teamplate/css/adminlte.min.css') }}">
</head>
<body class="bg-body-tertiary">
    <main class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
        <section class="bg-white border rounded-3 shadow-sm p-4 p-md-5 w-100" style="max-width: 620px">
            <p class="text-uppercase text-primary fw-semibold mb-2">POS Toko</p>
            <h1 class="h2 mb-3">Kelola produk dan stok toko</h1>
            <p class="text-secondary mb-4">Masuk atau buat akun untuk mengelola katalog produk.</p>

            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Buka dashboard</a>
            @else
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('login') }}" class="btn btn-primary">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary">Daftar akun</a>
                </div>
            @endauth
        </section>
    </main>
</body>
</html>
