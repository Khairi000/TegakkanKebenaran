<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    /**
     * Kolom yang bisa diisi secara massal
     */
    protected $fillable = [
        'user_id',
        'aspirasi_id',
        'isi',
    ];

    /**
     * Relasi ke user (siapa yang menulis komentar)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke aspirasi (komentar ini untuk aspirasi apa)
     */
    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class);
    }
}
