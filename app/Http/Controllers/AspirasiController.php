<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AspirasiController extends Controller
{
    public function create()
    {
        return view('aspirasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi'   => 'required|string',
        ]);

        // generate hash unik (blockchain-ready)
        $hash = hash('sha256', $request->judul . $request->isi . Auth::id() . now());

        Aspirasi::create([
            'user_id' => Auth::id(),
            'judul'   => $request->judul,
            'isi'     => $request->isi,
            'status'  => 'Dikirim',
            'hash'    => $hash,
        ]);

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi berhasil dikirim!');
    }

    public function index()
    {
        $aspirasis = Aspirasi::with('user')->latest()->get();
        return view('aspirasi.index', compact('aspirasis'));
    }

    public function show(Aspirasi $aspirasi)
    {
        return view('aspirasi.show', compact('aspirasi'));
    }

    public function updateStatus(Request $request, Aspirasi $aspirasi)
    {
        // ✅ hanya admin yang boleh update
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak punya akses');
        }

        $request->validate([
            'status' => 'required|in:Dikirim,Diproses,Selesai,Ditolak'
        ]);

        $aspirasi->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status aspirasi berhasil diperbarui!');
    }
}
