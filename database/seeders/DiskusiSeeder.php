<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Diskusi;
use App\Models\User;
use App\Models\Aspirasi;

class DiskusiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user & aspirasi yang sudah ada
        $user = User::first();
        $aspirasi = Aspirasi::first();

        // Jika belum ada data, hentikan agar tidak error
        if (!$user || !$aspirasi) {
            $this->command->warn('⚠️ Tidak ada data user atau aspirasi di database. Jalankan UserSeeder dan AspirasiSeeder terlebih dahulu.');
            return;
        }

        // Tambahkan 5 contoh diskusi
        $diskusiData = [
            'Setuju banget sama ide ini, semoga segera direalisasikan!',
            'Saya juga merasakan hal yang sama, perlu ada tindakan cepat.',
            'Menurut saya, perlu ditambah dukungan dari masyarakat sekitar.',
            'Bagus, tapi perlu dijelaskan lebih detail tentang langkah-langkahnya.',
            'Akan lebih baik kalau melibatkan komunitas lingkungan juga.'
        ];

        foreach ($diskusiData as $isi) {
            Diskusi::create([
                'aspirasi_id' => $aspirasi->id,
                'user_id' => $user->id,
                'isi' => $isi,
                'created_at' => now()->subMinutes(rand(1, 120)),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ DiskusiSeeder berhasil dijalankan!');
    }
}
