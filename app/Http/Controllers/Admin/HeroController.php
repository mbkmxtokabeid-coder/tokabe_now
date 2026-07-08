<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Heroe;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class HeroController extends Controller
{
    public function index()
    {
        // PERBAIKAN 1: Mengubah Heroe::all() menjadi urut berdasarkan sort_order
        $heroes = Heroe::orderBy('sort_order', 'asc')->get();
        return view('admin.hero.index', compact('heroes'));
    }

    public function create()
    {
        return view('admin.hero.create-hero');
    }

    public function createHero(Request $request)
    {
        $request->validate(
            [
                'judul_id' => 'required|min:3',
                'judul_en' => 'required|min:3',
                'deskripsi_id' => 'required|min:10',
                'deskripsi_en' => 'required|min:10',
                'gambar' => 'required|image|mimes:png,jpg,jpeg,webp|max:10240',
                'dooh_count' => 'nullable|integer|min:0',
                'ooh_count' => 'nullable|integer|min:0',
            ],
            [
                'judul_id.required' => 'Judul (ID) harus diisi',
                'judul_en.required' => 'Judul (EN) harus diisi',
                'deskripsi_id.required' => 'Deskripsi (ID) harus diisi',
                'deskripsi_en.required' => 'Deskripsi (EN) harus diisi',
                'gambar.required' => 'Gambar harus diisi',
                'judul_id.min' => 'Judul (ID) minimal 3 karakter',
                'deskripsi_id.min' => 'Deskripsi (ID) minimal 10 karakter',
                'gambar.mimes' => 'Format Gambar harus png/jpg/jpeg/webp',
                'gambar.image' => 'Harus foto/gambar',
                'gambar.max' => 'Ukuran maksimal 10Mb',
            ]
        );

        $hero = new Heroe();
        $hero->judul = [
            'id' => $request->judul_id,
            'en' => $request->judul_en
        ];
        $hero->deskripsi = [
            'id' => $request->deskripsi_id,
            'en' => $request->deskripsi_en
        ];
        $hero->dooh_count = $request->dooh_count;
        $hero->ooh_count = $request->ooh_count;

        // Handle status aktif (default 0 jika tidak diceklis)
        $hero->status = $request->has('status') ? 1 : 0;

        // PERBAIKAN TAMBAHAN: Set sort_order otomatis ke urutan paling bawah saat buat baru
        $maxOrder = Heroe::max('sort_order');
        $hero->sort_order = $maxOrder ? $maxOrder + 1 : 1;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = uniqid() . '.webp';
            
            // Proses gambar menggunakan Intervention Image v3
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());
            
            // Resize jika lebar lebih dari 1920px (mencegah gambar raksasa)
            $image->scaleDown(width: 1920);
            
            // Convert ke WebP dengan kualitas 80%
            $encoded = $image->toWebp(80);
            
            // Simpan file ke storage/app/public/image_hero
            Storage::disk('public')->put('image_hero/' . $fileName, (string) $encoded);

            // Simpan nama file di database
            $hero->gambar = $fileName;
        }

        $hero->save();

        return redirect('/admin/hero-list')->with('success', 'Kamu berhasil menambahkan hero baru!');
    }

    public function update($id)
    {
        $hero = Heroe::find($id);

        return view('admin.hero.update-hero', compact('hero'));
    }

    public function updateHero(Request $request, $id)
    {
        $hero = Heroe::find($id);

        $validated = $request->validate([
            'judul_id' => 'required|min:3',
            'judul_en' => 'required|min:3',
            'deskripsi_id' => 'required|min:10',
            'deskripsi_en' => 'required|min:10',
            'dooh_count' => 'nullable|integer|min:0',
            'ooh_count' => 'nullable|integer|min:0',
            'gambar' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:10240',
        ]);

        $hero->judul = [
            'id' => $request->judul_id,
            'en' => $request->judul_en
        ];
        $hero->deskripsi = [
            'id' => $request->deskripsi_id,
            'en' => $request->deskripsi_en
        ];
        $hero->dooh_count = $request->dooh_count;
        $hero->ooh_count = $request->ooh_count;

        // ✅ Simpan status dari switch (0 atau 1)
        $hero->status = $request->status;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = uniqid() . '.webp';

            // Hapus gambar lama jika ada
            if ($hero->gambar) {
                Storage::disk('public')->delete('image_hero/' . $hero->gambar);
            }

            // Proses gambar menggunakan Intervention Image v3
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());
            
            // Resize jika lebar lebih dari 1920px
            $image->scaleDown(width: 1920);
            
            // Convert ke WebP dengan kualitas 80%
            $encoded = $image->toWebp(80);
            
            // Simpan file ke storage/app/public/image_hero
            Storage::disk('public')->put('image_hero/' . $fileName, (string) $encoded);

            // Simpan nama file di database
            $hero->gambar = $fileName;
        }

        $hero->save();
        return redirect('/admin/hero-list')->with('update', 'Kamu berhasil meng-update hero!');
    }

    public function delete($id)
    {
        $hero = Heroe::find($id);
        
        if ($hero) {
            // Hapus file gambar dari storage jika ada
            if ($hero->gambar && Storage::exists('public/image_hero/' . $hero->gambar)) {
                Storage::delete('public/image_hero/' . $hero->gambar);
            }

            // Hapus data dari database
            $hero->delete();

            return redirect('/admin/hero-list')->with('success', 'You have successfully deleted hero data');
        }

        return redirect('/admin/hero-list')->with('error', 'Hero data not found');
    }
    
    public function reorder(Request $request)
    {
        $order = $request->input('order');
        
        if ($order) {
            foreach ($order as $index => $id) {
                // PERBAIKAN 2: Ubah 'Hero' menjadi 'Heroe' sesuai nama Model di atas
                Heroe::where('id', $id)->update(['sort_order' => $index + 1]);
            }
        }
    
        return response()->json(['success' => true, 'message' => 'Urutan berhasil diperbarui']);
    }

}