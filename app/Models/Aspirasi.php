<?php

namespace App\Models;
use App\Models\Komentar;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    /**
     * Kolom yang bisa diisi secara massal
     */
    protected $fillable = [
        'user_id',
        'judul',
        'isi',
        'foto',      // Path foto aspirasi (opsional)
        'dokumen',   // Path dokumen pendukung (opsional)
        'status',    // Status aspirasi: Dikirim, Diproses, Selesai
        'hash',      // Hash unik untuk blockchain
        'votes',     // Jumlah vote
    ];

    /**
     * Default value untuk beberapa kolom
     */
    protected $attributes = [
        'votes' => 0,
        'status' => 'Dikirim',
    ];

    /**
     * Relasi ke user (pembuat aspirasi)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi many-to-many ke user yang melakukan vote
     */
    public function voters()
    {
        return $this->belongsToMany(User::class, 'aspirasi_user_votes')
                    ->withTimestamps();
    }

    /**
     * Toggle vote oleh user tertentu.
     * Jika user sudah vote → vote dibatalkan.
     * Jika user belum vote → vote ditambahkan.
     *
     * @param \App\Models\User $user
     * @return bool true = vote ditambahkan, false = vote dibatalkan
     */
    public function toggleVote(User $user): bool
    {
        if ($this->voters()->where('user_id', $user->id)->exists()) {
            $this->voters()->detach($user->id);
            $this->decrement('votes');
            return false; // Vote dibatalkan
        }

        $this->voters()->attach($user->id);
        $this->increment('votes');
        return true; // Vote ditambahkan
    }

    /**
     * Relasi ke komentar (aspirasi bisa punya banyak komentar)
     */
    public function komentar()
    {
        return $this->hasMany(Komentar::class);
    }

    public function komentars()
    {
        return $this->hasMany(\App\Models\Komentar::class, 'aspirasi_id');
    }

    public function diskusis()
{
    return $this->hasMany(\App\Models\Diskusi::class);
}



}
