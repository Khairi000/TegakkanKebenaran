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
        Schema::create('aspirasi_user_votes', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke aspirasi
            $table->foreignId('aspirasi_id')->constrained()->onDelete('cascade');
            
            // Relasi ke user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();

            // Pastikan kombinasi aspirasi_id + user_id unik supaya 1 user cuma bisa vote 1 kali
            $table->unique(['aspirasi_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aspirasi_user_votes');
    }
};
