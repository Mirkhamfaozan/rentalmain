<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'user_id' => 18,
                'nama_motor' => 'Honda Scoopy',
                'brand' => 'Honda',
                'cc_motor' => 110,
                'harga_harian' => 75000.00,
                'harga_mingguan' => 350000.00,
                'harga_bulanan' => 900000.00,
                'transmisi_motor' => 'Automatic',
                'tipe_motor' => 'Scooter',
                'tahun_produksi' => 2023,
                'warna' => 'Merah',
                'no_mesin' => 'MESIN123456',
                'no_rangka' => 'RANGKA123456',
                'gambar_utama' => 'scoopy.jpg',
                'deskripsi' => 'Motor matic hemat bahan bakar, cocok untuk harian.',
                'stok' => 5,
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 18,
                'nama_motor' => 'Yamaha NMAX',
                'brand' => 'Yamaha',
                'cc_motor' => 155,
                'harga_harian' => 100000.00,
                'harga_mingguan' => 450000.00,
                'harga_bulanan' => 1200000.00,
                'transmisi_motor' => 'Automatic',
                'tipe_motor' => 'Scooter',
                'tahun_produksi' => 2022,
                'warna' => 'Hitam',
                'no_mesin' => 'MESIN789012',
                'no_rangka' => 'RANGKA789012',
                'gambar_utama' => 'nmax.jpg',
                'deskripsi' => 'Motor matic premium dengan performa tangguh.',
                'stok' => 3,
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
