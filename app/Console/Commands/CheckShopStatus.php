<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckShopStatus extends Command
{
    /**
     * Nama dan argumen perintah terminal.
     */
    protected $signature = 'pos:status {jam?}';

    /**
     * Deskripsi perintah.
     */
    protected $description = 'Mengecek status operasional Toko Kelontong POS';

    /**
     * Logika utama perintah.
     */
    public function handle()
    {
        // 1. Meminta input nama kasir (Tugas Mandiri No. 1)
        $namaKasir = $this->ask('Masukkan nama Anda');

        // 2. Mengambil argumen jam (default 10 pagi)
        $jam = $this->argument('jam') ?? 10;

        $this->info("=== SISTEM MONITORING TOKO KELONTONG ===");

        // 3. Pengecekan kondisi jam operasional (08:00 - 21:00) (Tugas Mandiri No. 2)
        if ($jam >= 8 && $jam <= 21) {
            $this->info("Halo {$namaKasir}, Status Toko pada jam {$jam}:00 WIB adalah: BUKA");
            $this->comment("Silakan kasir bersiap di meja transaksi.");
        } else {
            $this->error("Halo {$namaKasir}, Status Toko pada jam {$jam}:00 WIB adalah: TUTUP");
            $this->warn("Akses transaksi kasir dinonaktifkan sementara.");
        }
    }
}