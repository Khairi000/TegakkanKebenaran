<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspirasi;
use Illuminate\Support\Facades\Auth;
use App\Events\KomentarBaru;

class DiskusiController extends Controller
{
    public function index()
    {
        $aspirasis = Aspirasi::latest()->get();
        return view('diskusi.index', compact('aspirasis'));
    }

    public function show(Aspirasi $aspirasi)
    {
        // Ambil semua diskusi terkait aspirasi beserta user-nya
        $diskusis = $aspirasi->diskusis()->with('user')->latest()->get();

        return view('diskusi.show', compact('aspirasi', 'diskusis'));
    }

    public function storeDiskusi(Request $request, Aspirasi $aspirasi)
    {
        $request->validate([
            'isi' => 'required|string',
        ]);

        $diskusi = $aspirasi->diskusis()->create([
            'user_id' => Auth::id(),
            'isi' => $request->isi,
        ]);

        return response()->json($diskusi);
    }
}
