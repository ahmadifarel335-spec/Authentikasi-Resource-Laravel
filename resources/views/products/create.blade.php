@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.produk.index') }}" class="text-decoration-none">&larr; Kembali ke produk</a>
        <h1 class="h3 mt-3 mb-1">Tambah produk</h1>
        <p class="text-secondary mb-0">Isi informasi produk dan stok awal.</p>
    </div>

    <div class="card border-0 shadow-sm" style="max-width: 760px">
        <div class="card-body p-4">
            @include('products._form', ['product' => null])
        </div>
    </div>
@endsection
