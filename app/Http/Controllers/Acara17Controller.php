<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // PENTING: Wajib di-import

class Acara17Controller extends Controller
{
    public function index()
    {
        // 1. Mengambil semua data dari tabel products
        $products = DB::table('products')->get();

        // 2. Mengambil data user berdasarkan kondisi email/id
        $user = DB::table('users')->where('id', 1)->first();

        // Tampilkan hasil produk ke layar (format JSON)
        return response()->json([
            'status' => 'Sukses',
            'data_produk' => $products,
            'data_user' => $user
        ]);
    }
}