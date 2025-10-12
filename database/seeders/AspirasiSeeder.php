<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aspirasi;

class AspirasiSeeder extends Seeder
{
    public function run(): void
    {
        $aspirasiDummy = [
            [
                'judul' => 'Perbaikan Jalan Rusak di Jalan Merdeka',
                'isi' => 'Banyak jalan berlubang di sekitar Jalan Merdeka, mohon segera diperbaiki untuk keselamatan pengguna jalan.',
                'status' => 'Diproses',
                'user_id' => 7, // id user biasa
            ],
            [
                'judul' => 'Pohon Tumbang Menghalangi Jalan',
                'isi' => 'Ada pohon tumbang di depan sekolah yang mengganggu akses jalan utama.',
                'status' => 'Dikirim',
                'user_id' => 8,
            ],
            [
                'judul' => 'Lampu Jalan Padam di RT 03',
                'isi' => 'Sudah beberapa hari lampu jalan padam di wilayah RT 03, membuat lingkungan menjadi gelap.',
                'status' => 'Selesai',
                'user_id' => 8,
            ],
            [
                'judul' => 'Saluran Air Tersumbat',
                'isi' => 'Setiap hujan deras, air meluap ke jalan karena saluran air tersumbat.',
                'status' => 'Selesai',
                'user_id' => 7,
            ],
        ];

        foreach ($aspirasiDummy as $aspirasi) {
            Aspirasi::create($aspirasi);
        }
    }
}
