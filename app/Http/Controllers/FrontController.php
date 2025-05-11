<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use App\Repositories\BeritaRepository;
use App\Repositories\JadwalRepository;
use App\Repositories\KeuanganRepository;
use App\Repositories\JenisSuratRepository;
use App\Models\JenisSurat;
use App\Models\Jadwal;

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
            'keyword' => ['required', 'string', 'min:3', 'max:255'],
        ]);

        $keyword = $request->keyword;

        $beritas = Berita::query()
            ->with(['kategoriBerita', 'admin'])
            ->where('judul', 'like', '%' . $keyword . '%')
            ->orWhere('isi', 'like', '%' . $keyword . '%')
            ->latest()
            ->paginate(9);

        return view('front.berita.search', compact('beritas', 'keyword'));
    }

    public function beritaIndex(Request $request)
    {
        $beritas = Berita::query()
            ->with(['kategoriBerita', 'admin'])
            ->latest()
            ->paginate(9);

        $kategori_beritas = KategoriBerita::all();

        return view('front.berita.index', compact('beritas', 'kategori_beritas'));
    }

    public function beritaDetail(Berita $berita)
    {
        $kategori_beritas = KategoriBerita::all();

        $beritas = Berita::with(['kategoriBerita'])
            ->where('id', '!=', $berita->id)
            ->where('kategori_berita_id', $berita->kategori_berita_id)
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
        $jadwals = Jadwal::query()
            ->orderBy('waktu', 'asc')
            ->paginate(2);

        $groupedJadwals = $jadwals->getCollection()->groupBy(function($jadwal) {
            return $jadwal->waktu->format('Y-m');
        });

        return view('front.jadwal-kegiatan', [
            'jadwals' => $jadwals,
            'groupedJadwals' => $groupedJadwals
        ]);
    }

    public function layananSurat()
    {
        $jenisSurat = JenisSurat::paginate(14);
        
        return view('front.layanan-surat', compact('jenisSurat'));
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