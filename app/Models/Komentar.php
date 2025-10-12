<?php

namespace App\Models;
use App\Models\Aspirasi;


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
        return $this->belongsTo(\App\Models\Aspirasi::class, 'aspirasi_id');
    }

}
