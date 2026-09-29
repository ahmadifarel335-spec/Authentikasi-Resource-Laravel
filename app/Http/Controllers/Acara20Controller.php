<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import Model Product

class Acara20Controller extends Controller
{
    public function index()
    {
        // Mengambil produk beserta data kategori pasangan relasinya (Eager Loading)
        $products = Product::with('category')->get();

        return response()->json([
            'status' => 'Sukses Eloquent Relasi (Acara 20)',
            'data_produk_dengan_kategori' => $products
        ]);
    }
}