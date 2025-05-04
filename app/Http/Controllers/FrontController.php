<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;

class FrontController extends Controller
{
    public function index()
    {
        $berita_terbarus = Berita::with('kategoriBerita')
            ->orderByDesc('tanggal_post')
            ->take(3)
            ->get();

        $beritas = Berita::all();

        $kategori_beritas = KategoriBerita::all();

        return view('welcome', compact('berita_terbarus', 'kategori_beritas', 'beritas'));
    }

    public function apbdes()
    {
        return view('front.apbdes');
    }

    public function inventaris()
    {
        return view('front.inventaris');
    }

    public function jadwal()
    {
        return view('front.jadwal');
    }

    public function category(KategoriBerita $kategori_berita)
    {
        $kategori_beritas = KategoriBerita::with('beritas')->get();

        return view('front.category', compact('kategori_berita', 'kategori_beritas'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'keyword' => ['required', 'string', 'max:255']
        ]);

        $kategori_beritas = KategoriBerita::all();
        $keyword = $request->keyword;

        $beritas = Berita::with(['kategoriBerita', 'admin'])
            ->where('judul', 'like', '%' . $keyword . '%')->paginate(6);

        return view('front.search', compact('beritas', 'keyword', 'kategori_beritas'));
    }

    public function details(Berita $berita)
    {
        $kategori_beritas = KategoriBerita::all();

        $beritas = Berita::with(['kategoriBerita'])
            ->where('is_featured', 'not_featured')
            ->where('id', '!=', $berita->id)
            ->latest()
            ->take(3)
            ->get();

        return view('front.berita.detail', compact(
            'berita',
            'kategori_beritas',
            'beritas'
        ));
    }
} 