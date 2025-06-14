<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Jadwal;
use App\Models\Keuangan;
use App\Enum\BeritaStatus;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use App\Enum\KategoriAnggaranEnum;
use App\Repositories\BeritaRepository;
use App\Repositories\JadwalRepository;
use App\Repositories\KeuanganRepository;
use App\Repositories\JenisSuratRepository;
use App\Repositories\VisiMisiRepository;
use App\Repositories\KepengurusanRepository;

class FrontController extends Controller
{
    protected $beritaRepo;
    protected $jadwalRepo;
    protected $jenisSuratRepo;
    protected $keuanganRepo;
    protected $visiMisiRepo;
    protected $kepengurusanRepo;

    public function __construct(
        BeritaRepository $beritaRepo,
        JadwalRepository $jadwalRepo,
        JenisSuratRepository $jenisSuratRepo,
        KeuanganRepository $keuanganRepo,
        VisiMisiRepository $visiMisiRepo,
        KepengurusanRepository $kepengurusanRepo
    ) {
        $this->beritaRepo = $beritaRepo;
        $this->jadwalRepo = $jadwalRepo;
        $this->jenisSuratRepo = $jenisSuratRepo;
        $this->keuanganRepo = $keuanganRepo;
        $this->visiMisiRepo = $visiMisiRepo;
        $this->kepengurusanRepo = $kepengurusanRepo;
    }

    public function index()
    {
        $beritaUtama = $this->beritaRepo->getBeritaUtama();
        $beritaTerbaru = $this->beritaRepo->getBeritaTerbaru();
        $jadwalKegiatan = $this->jadwalRepo->getJadwalKegiatan();
        $layananSurat = $this->jenisSuratRepo->getLayananSurat();
        $visiMisi = $this->visiMisiRepo->getLatestVisiMisi();

        // Get all officials grouped by roles
        $kepalaDesa = $this->kepengurusanRepo->getKepalaDesa();
        $sekretariatDesa = $this->kepengurusanRepo->getSekretariatDesa();
        $pelaksanaTeknis = $this->kepengurusanRepo->getPelaksanaTeknis();
        $kepalaDusun = $this->kepengurusanRepo->getAllKepalaDusun();

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
            'visiMisi',
            'kepalaDesa',
            'sekretariatDesa',
            'pelaksanaTeknis',
            'kepalaDusun',
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
        // Get current year for default filter
        $tahunSekarang = date('Y');
        $tahunAnggaran = request('tahun', $tahunSekarang);

        // Get raw data from repository with year filter
        $totalPendapatan = $this->keuanganRepo->getTotalPendapatan($tahunAnggaran);
        $totalBelanja = $this->keuanganRepo->getTotalBelanja($tahunAnggaran);
        $totalPembiayaan = $this->keuanganRepo->getTotalPembiayaan($tahunAnggaran);

        // Get detailed data and transform into array of objects
        $sumberPendapatan = $this->keuanganRepo->getSumberPendapatan($tahunAnggaran)
            ->map(function ($total, $sumber) {
                return (object) [
                    'sumber_dana' => $sumber,
                    'total' => $total
                ];
            })
            ->values();

        $jenisBelanja = $this->keuanganRepo->getJenisBelanja($tahunAnggaran)
            ->map(function ($total, $jenis) {
                return (object) [
                    'sub_kategori' => $jenis,
                    'total' => $total
                ];
            })
            ->values();

        $jenisPembiayaan = $this->keuanganRepo->getJenisPembiayaan($tahunAnggaran)
            ->map(function ($total, $jenis) {
                return (object) [
                    'sub_kategori' => $jenis,
                    'total' => $total
                ];
            })
            ->values();

        // Get detailed program information
        $programPendapatan = $this->keuanganRepo->getProgramDetails(KategoriAnggaranEnum::PENDAPATAN->value, $tahunAnggaran);
        $programBelanja = $this->keuanganRepo->getProgramDetails(KategoriAnggaranEnum::BELANJA->value, $tahunAnggaran);
        $programPembiayaan = $this->keuanganRepo->getProgramDetails(KategoriAnggaranEnum::PEMBIAYAAN->value, $tahunAnggaran);

        // Get available years for filter
        $tahunTersedia = $this->keuanganRepo->getAvailableYears();

        return view('front.apbdes', compact(
            'totalPendapatan',
            'totalBelanja',
            'totalPembiayaan',
            'sumberPendapatan',
            'jenisBelanja',
            'jenisPembiayaan',
            'programPendapatan',
            'programBelanja',
            'programPembiayaan',
            'tahunAnggaran',
            'tahunTersedia'
        ));
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

    public function jadwalKegiatan()
    {
        $jadwals = Jadwal::query()
            ->orderBy('waktu', 'asc')
            ->paginate(20);

        $groupedJadwals = $jadwals->getCollection()->groupBy(function ($jadwal) {
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

    public function galeri(Request $request)
    {
        $activeTab = $request->get('tab', 'semua'); // Default to 'semua' if no tab specified
        $itemsPerPage = 14; // Number of items per page

        $beritas = Berita::select('thumbnail', 'judul', 'tanggal_post')
            ->where('status', BeritaStatus::PUBLISHED->name)
            ->latest('tanggal_post')
            ->paginate($itemsPerPage)
            ->appends(['tab' => $activeTab]);

        $keuangans = Keuangan::select('file_bukti', 'nama_program', 'tahun_anggaran')
            ->latest('created_at')
            ->paginate($itemsPerPage)
            ->appends(['tab' => $activeTab]);

        $jadwals = Jadwal::select('foto_kegiatan', 'nama_kegiatan', 'waktu')
            ->latest('waktu')
            ->paginate($itemsPerPage)
            ->appends(['tab' => $activeTab]);

        return view('front.galeri', compact('beritas', 'keuangans', 'jadwals', 'activeTab'));
    }
}