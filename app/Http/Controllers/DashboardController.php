<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total = Aspirasi::count();
        $dikirim = Aspirasi::where('status', 'Dikirim')->count();
        $diproses = Aspirasi::where('status', 'Diproses')->count();
        $selesai = Aspirasi::where('status', 'Selesai')->count();

        // Ambil 5 aspirasi terbaru
        $aspirasiTerbaru = Aspirasi::latest()->take(3)->get();

        // Kirim semua ke view
        return view('dashboard', compact('total', 'dikirim', 'diproses', 'selesai', 'aspirasiTerbaru'));
    }
}
