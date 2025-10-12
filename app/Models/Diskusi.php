<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskusi extends Model
{
    use HasFactory;

    protected $fillable = ['aspirasi_id', 'user_id', 'isi'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class);
    }
}
