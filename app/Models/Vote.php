<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['user_id','aspirasi_id'];

    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
