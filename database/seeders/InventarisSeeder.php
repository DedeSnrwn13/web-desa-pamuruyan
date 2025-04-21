<?php

namespace Database\Seeders;

use App\Models\Inventaris;
use Illuminate\Database\Seeder;

class InventarisSeeder extends Seeder
{
    public function run(): void
    {
        $inventaris = [
            [
                'admin_id' => 1,
                'nama_barang' => 'Laptop Dell Latitude',
                'kode_barang' => 'LPT-001',
                'jumlah' => 2,
                'harga' => 12000000,
                'lokasi' => 'Ruang Sekretaris',
                'kondisi' => 'baik',
                'keterangan' => 'Laptop untuk keperluan administrasi',
                'tanggal_pembelian' => '2023-01-15',
                'sumber_dana' => 'APBD',
                'status' => 'aktif',
                'gambar' => null
            ],
            [
                'admin_id' => 1,
                'nama_barang' => 'Printer Epson L3150',
                'kode_barang' => 'PRT-001',
                'jumlah' => 1,
                'harga' => 3500000,
                'lokasi' => 'Ruang Tata Usaha',
                'kondisi' => 'baik',
                'keterangan' => 'Printer All-in-One',
                'tanggal_pembelian' => '2023-02-20',
                'sumber_dana' => 'APBD',
                'status' => 'aktif',
                'gambar' => null
            ],
            [
                'admin_id' => 1,
                'nama_barang' => 'Meja Kerja',
                'kode_barang' => 'MJ-001',
                'jumlah' => 5,
                'harga' => 1500000,
                'lokasi' => 'Ruang Kantor',
                'kondisi' => 'baik',
                'keterangan' => 'Meja kerja standar',
                'tanggal_pembelian' => '2023-03-10',
                'sumber_dana' => 'APBD',
                'status' => 'aktif',
                'gambar' => null
            ],
            [
                'admin_id' => 1,
                'nama_barang' => 'Kursi Staff',
                'kode_barang' => 'KS-001',
                'jumlah' => 10,
                'harga' => 800000,
                'lokasi' => 'Ruang Kantor',
                'kondisi' => 'baik',
                'keterangan' => 'Kursi kerja staff',
                'tanggal_pembelian' => '2023-03-10',
                'sumber_dana' => 'APBD',
                'status' => 'aktif',
                'gambar' => null
            ],
            [
                'admin_id' => 1,
                'nama_barang' => 'AC Panasonic 1PK',
                'kode_barang' => 'AC-001',
                'jumlah' => 3,
                'harga' => 4500000,
                'lokasi' => 'Ruang Kepala Desa',
                'kondisi' => 'baik',
                'keterangan' => 'AC Split Wall Mounted',
                'tanggal_pembelian' => '2023-04-05',
                'sumber_dana' => 'APBD',
                'status' => 'aktif',
                'gambar' => null
            ],
            [
                'admin_id' => 1,
                'nama_barang' => 'Lemari Arsip',
                'kode_barang' => 'LA-001',
                'jumlah' => 2,
                'harga' => 2500000,
                'lokasi' => 'Ruang Arsip',
                'kondisi' => 'baik',
                'keterangan' => 'Lemari penyimpanan dokumen',
                'tanggal_pembelian' => '2023-05-15',
                'sumber_dana' => 'APBD',
                'status' => 'aktif',
                'gambar' => null
            ],
            [
                'admin_id' => 1,
                'nama_barang' => 'Proyektor Epson',
                'kode_barang' => 'PRJ-001',
                'jumlah' => 1,
                'harga' => 8500000,
                'lokasi' => 'Ruang Rapat',
                'kondisi' => 'baik',
                'keterangan' => 'Proyektor untuk presentasi',
                'tanggal_pembelian' => '2023-06-20',
                'sumber_dana' => 'APBD',
                'status' => 'aktif',
                'gambar' => null
            ],
            [
                'admin_id' => 1,
                'nama_barang' => 'UPS APC',
                'kode_barang' => 'UPS-001',
                'jumlah' => 3,
                'harga' => 1200000,
                'lokasi' => 'Ruang Server',
                'kondisi' => 'baik',
                'keterangan' => 'UPS untuk backup listrik',
                'tanggal_pembelian' => '2023-07-10',
                'sumber_dana' => 'APBD',
                'status' => 'aktif',
                'gambar' => null
            ]
        ];

        foreach ($inventaris as $item) {
            Inventaris::create($item);
        }
    }
}