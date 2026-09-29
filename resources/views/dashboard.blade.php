@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <p class="text-uppercase text-secondary fw-semibold mb-1">Ringkasan</p>
            <h1 class="h3 mb-1">Dashboard toko</h1>
            <p class="text-secondary mb-0">Halo, {{ auth()->user()->name }}.</p>
        </div>
        <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">Tambah produk</a>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3 mb-4">
        <div class="col">
            <section class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-secondary mb-2">Produk terdaftar</p>
                    <p class="h2 mb-0">{{ number_format($totalProducts) }}</p>
                </div>
            </section>
        </div>
        <div class="col">
            <section class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-secondary mb-2">Kategori</p>
                    <p class="h2 mb-0">{{ number_format($totalCategories) }}</p>
                </div>
            </section>
        </div>
        <div class="col">
            <section class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-secondary mb-2">Stok menipis (≤ 5)</p>
                    <p class="h2 mb-0 text-warning-emphasis">{{ number_format($lowStockProducts) }}</p>
                </div>
            </section>
        </div>
        <div class="col">
            <section class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-secondary mb-2">Stok habis</p>
                    <p class="h2 mb-0 text-danger">{{ number_format($outOfStockProducts) }}</p>
                </div>
            </section>
        </div>
    </div>

    <section class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center gap-3 py-3">
            <h2 class="h5 mb-0">Produk terbaru</h2>
            <a href="{{ route('admin.produk.index') }}" class="text-decoration-none">Lihat semua</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Nama produk</th>
                        <th scope="col">SKU</th>
                        <th scope="col">Kategori</th>
                        <th scope="col" class="text-end">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestProducts as $product)
                        <tr>
                            <td class="fw-semibold">{{ $product->name }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td class="text-end">{{ number_format($product->stock) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-secondary py-5">Belum ada produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
