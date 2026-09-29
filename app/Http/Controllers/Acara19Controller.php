<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import Model Product

class Acara19Controller extends Controller
{
    public function index()
    {
        // 1. CREATE: Menambah Data Baru ke Database
        $product = new Product();
        $product->category_id = 1;
        $product->name = 'Produk Acara 19';
        $product->sku = 'PRD-' . rand(1000, 9999);
        $product->price = 75000;
        $product->stock = 15;
        $product->save(); // Simpan data ke database

        // 2. UPDATE: Mengubah Data yang Baru Saja Dibuat
        $product->price = 80000;
        $product->save(); // Simpan perubahan ke database

        // 3. READ: Mengambil Data Hasil Manipulasi
        $result = Product::find($product->id);

        return response()->json([
            'status' => 'Sukses Eloquent ORM Part 2 (Manipulasi Data)',
            'data_produk_baru' => $result
        ]);
    }
}