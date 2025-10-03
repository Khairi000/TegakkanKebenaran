<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aspirasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'judul', 'isi', 'status', 'hash'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Vote
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // Attribute tambahan untuk hitung jumlah vote
    public function getVoteCountAttribute()
    {
        return $this->votes()->count();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

}
