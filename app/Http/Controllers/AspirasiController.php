<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Services\BlockchainService;

class AspirasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 📌 Tampilkan semua aspirasi (urut berdasarkan vote & waktu)
     */
    public function index(): View
    {
        $aspirasis = Aspirasi::with(['user', 'komentar.user', 'voters'])
            ->withCount(['voters as votes_count', 'komentar as komentar_count'])
            ->orderByDesc('votes_count')
            ->orderByDesc('created_at')
            ->paginate(10); // Ganti get() dengan paginate() untuk pagination

        return view('aspirasi.index', compact('aspirasis'));
    }

    /**
     * 📌 Form buat aspirasi baru (user)
     */
    public function create(): View
    {
        abort_unless(Auth::user()->isUser(), 403, 'Hanya user biasa yang bisa membuat aspirasi.');

        return view('aspirasi.create');
    }

    /**
     * 📌 Simpan aspirasi baru dan kirim ke blockchain
     */
    public function store(Request $request, BlockchainService $blockchain): RedirectResponse
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi'   => 'required|string',
            'foto'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Simpan foto (jika ada)
        $fotoPath = $request->hasFile('foto')
            ? $request->file('foto')->store('aspirasi', 'public')
            : null;

        // Buat entri aspirasi di database
        $aspirasi = Aspirasi::create([
            'user_id' => Auth::id(),
            'judul'   => $request->judul,
            'isi'     => $request->isi,
            'foto'    => $fotoPath,
            'status'  => 'Dikirim',
        ]);

        // Simpan ke blockchain
        try {
            $hash = $blockchain->storeAspirasi($request->judul, $request->isi);
            $aspirasi->update(['hash' => $hash]);
            $msg = 'Aspirasi berhasil dikirim dan disimpan di blockchain!';
        } catch (\Exception $e) {
            $msg = 'Aspirasi berhasil dikirim, tetapi gagal disimpan di blockchain: ' . $e->getMessage();
        }

        return redirect()->route('aspirasi.index')->with('success', $msg);
    }

    /**
     * 📌 Detail aspirasi
     */
    public function show(Aspirasi $aspirasi): View
    {
        $aspirasi->load(['user', 'voters', 'komentar.user']);
        return view('aspirasi.show', compact('aspirasi'));
    }

    /**
     * 📌 Update status & dokumen aspirasi (admin)
     */
    public function updateStatus(Request $request, Aspirasi $aspirasi): RedirectResponse
    {
        abort_unless(Auth::user()->isAdmin(), 403, 'Hanya admin yang bisa mengubah status.');

        $request->validate([
            'status'  => 'required|string|max:100',
            'dokumen' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,png,jpg,jpeg|max:5120',
        ]);

        $data = ['status' => $request->status];

        // Upload dokumen baru (hapus lama jika ada)
        if ($request->hasFile('dokumen')) {
            if ($aspirasi->dokumen && Storage::disk('public')->exists($aspirasi->dokumen)) {
                Storage::disk('public')->delete($aspirasi->dokumen);
            }
            $data['dokumen'] = $request->file('dokumen')->store('dokumen', 'public');
        }

        $aspirasi->update($data);

        return redirect()->route('aspirasi.index', $aspirasi)
            ->with('success', 'Status dan dokumen berhasil diperbarui!');
    }

    /**
     * 📌 Voting aspirasi (toggle vote)
     */
    public function vote(Aspirasi $aspirasi): RedirectResponse
    {
        $user = Auth::user();
        abort_unless($user->isUser(), 403, 'Hanya user biasa yang bisa melakukan voting.');

        $hasVoted = $aspirasi->voters()->where('user_id', $user->id)->exists();

        if ($hasVoted) {
            $aspirasi->voters()->detach($user->id);
            $aspirasi->decrement('votes');
            $msg = 'Vote Anda dibatalkan.';
        } else {
            $aspirasi->voters()->attach($user->id);
            $aspirasi->increment('votes');
            $msg = 'Terima kasih, suara Anda berhasil dikirim!';
        }

        return back()->with('success', $msg);
    }
}
