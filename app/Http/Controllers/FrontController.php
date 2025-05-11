<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use App\Repositories\BeritaRepository;
use App\Repositories\JadwalRepository;
use App\Repositories\KeuanganRepository;
use App\Repositories\JenisSuratRepository;

class FrontController extends Controller
{
    protected $beritaRepo;
    protected $jadwalRepo;
    protected $jenisSuratRepo;
    protected $keuanganRepo;

    public function __construct(
        BeritaRepository $beritaRepo,
        JadwalRepository $jadwalRepo,
        JenisSuratRepository $jenisSuratRepo,
        KeuanganRepository $keuanganRepo
    ) {
        $this->beritaRepo = $beritaRepo;
        $this->jadwalRepo = $jadwalRepo;
        $this->jenisSuratRepo = $jenisSuratRepo;
        $this->keuanganRepo = $keuanganRepo;
    }
    
    public function index()
    {
        $beritaUtama = $this->beritaRepo->getBeritaUtama();
        $beritaTerbaru = $this->beritaRepo->getBeritaTerbaru();
        $jadwalKegiatan = $this->jadwalRepo->getJadwalKegiatan();
        $layananSurat = $this->jenisSuratRepo->getLayananSurat();
        
        $totalPendapatan = $this->keuanganRepo->getTotalPendapatan();
        $totalBelanja = $this->keuanganRepo->getTotalBelanja();
        $totalPembiayaan = $this->keuanganRepo->getTotalPembiayaan();
        
        $sumberPendapatan = $this->keuanganRepo->getSumberPendapatan();
        $jenisBelanja = $this->keuanganRepo->getJenisBelanja();
        $jenisPembiayaan = $this->keuanganRepo->getJenisPembiayaan();

        return view('welcome', compact(
            'beritaUtama',
            'beritaTerbaru',
            'jadwalKegiatan',
            'layananSurat',
            'totalPendapatan',
            'totalBelanja',
            'totalPembiayaan',
            'sumberPendapatan',
            'jenisBelanja',
            'jenisPembiayaan'
        ));
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
            'keyword' => ['required', 'string', 'max:255'],
        ]);

        $kategori_beritas = KategoriBerita::all();
        $keyword = $request->keyword;

        $beritas = Berita::with(['kategoriBerita', 'admin'])
            ->where('judul', 'like', '%' . $keyword . '%')
            ->paginate(6);

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

        return view('front.berita.detail', compact('berita', 'kategori_beritas', 'beritas'));
    }

    public function kepengurusan()
    {
        //
    }

    public function jadwalKegiatan()
    {
        // 
    }

    public function layananSurat()
    {
        // 
    }

    public function visiMisi()
    {
        // 
    }

    public function galeri()
    {
        // 
    }
}