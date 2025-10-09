<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aspirasis', function (Blueprint $table) {
            $table->id();

            // Relasi ke user yang membuat aspirasi
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('judul');                      // Judul aspirasi
            $table->text('isi');                          // Isi aspirasi
            $table->string('foto')->nullable();           // Path foto (opsional)
            $table->string('dokumen')->nullable();        // Path dokumen pendukung (opsional)
            $table->string('status')->default('Dikirim'); // Status awal aspirasi
            $table->string('hash', 64)->nullable();       // Hash unik untuk blockchain
            $table->unsignedInteger('votes')->default(0); // Jumlah vote

            $table->timestamps();                         // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aspirasis');
    }
};
