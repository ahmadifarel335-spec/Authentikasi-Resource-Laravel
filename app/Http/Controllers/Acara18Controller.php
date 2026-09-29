<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import Model Product

class Acara18Controller extends Controller
{
    public function index()
    {
        // 1. Retrieve: Mengambil semua data produk
        $allProducts = Product::all();

        // 2. Retrieve: Mengambil 1 data produk berdasarkan ID
        $singleProduct = Product::find(1);

        // Menampilkan hasil dalam format JSON
        return response()->json([
            'status' => 'Sukses Eloquent ORM',
            'semua_produk' => $allProducts,
            'detail_produk_1' => $singleProduct
        ]);
    }
}