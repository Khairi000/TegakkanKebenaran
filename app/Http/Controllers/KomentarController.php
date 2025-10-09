<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomentarController extends Controller
{
    public function store(Request $request, $aspirasiId)
    {
        $request->validate([
            'isi' => 'required|string|max:500',
        ]);

        Komentar::create([
            'aspirasi_id' => $aspirasiId,
            'user_id' => Auth::id(),
            'isi' => $request->isi,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}
