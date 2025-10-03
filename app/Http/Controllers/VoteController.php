<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Aspirasi;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function store(Aspirasi $aspirasi)
    {
        // cek apakah user sudah vote sebelumnya
        $exists = Vote::where('user_id', Auth::id())
            ->where('aspirasi_id', $aspirasi->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah vote aspirasi ini.');
        }

        Vote::create([
            'user_id' => Auth::id(),
            'aspirasi_id' => $aspirasi->id
        ]);

        return back()->with('success', 'Vote berhasil dikirim!');
    }
}
