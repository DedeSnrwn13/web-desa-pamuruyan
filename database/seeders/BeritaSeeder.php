<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create admin
        $admin = Admin::first();
        if (!$admin) {
            $admin = Admin::factory()->create();
        }

        // Get all kategori berita
        $kategoriBerita = KategoriBerita::all();

        // Create sample news for each category
        foreach ($kategoriBerita as $kategori) {
            // Create first berita
            Berita::create([
                'admin_id' => $admin->id,
                'kategori_berita_id' => $kategori->id,
                'judul' => 'Berita ' . $kategori->nama . ' Terbaru',
                'slug' => 'berita-' . strtolower(str_replace(' ', '-', $kategori->nama)) . '-terbaru',
                'isi' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\n\nDuis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
                'status' => 'PUBLISHED',
                'thumbnail' => null, // Will use placeholder image
                'tanggal_post' => now(),
            ]);

            // Create second berita
            Berita::create([
                'admin_id' => $admin->id,
                'kategori_berita_id' => $kategori->id,
                'judul' => 'Perkembangan ' . $kategori->nama . ' Desa',
                'slug' => 'perkembangan-' . strtolower(str_replace(' ', '-', $kategori->nama)) . '-desa',
                'isi' => "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.\n\nNemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.",
                'status' => 'PUBLISHED',
                'thumbnail' => null, // Will use placeholder image
                'tanggal_post' => now()->subDays(rand(1, 30)),
            ]);
        }
    }
} 