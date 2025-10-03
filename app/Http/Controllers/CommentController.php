<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Aspirasi $aspirasi)
    {
        $request->validate([
            'isi' => 'required|string|max:500'
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'aspirasi_id' => $aspirasi->id,
            'isi' => $request->isi
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}