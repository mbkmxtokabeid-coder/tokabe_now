<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;
use App\Models\Lokasi;
use App\Models\Lokasiooh;
use App\Models\Heroe;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class LokasioohController extends Controller
{
    public function index($wilayah)
    {
        $lokasiooh = Lokasiooh::where('wilayah', $wilayah)->get();
        return view('admin.lokasiooh.index', compact('lokasiooh', 'wilayah'));
    }

    public function edit($id)
    {
        $lokasiooh = Lokasiooh::find($id);
        return view('admin.lokasiooh.update-lokasiooh', compact('lokasiooh'));
    }

    public function wilayah()
    {
        $lokasiooh = DB::table('lokasioohs')->selectRaw('LOWER(wilayah) as wilayah, COUNT(*) as jumlah')->groupBy('wilayah')->get();
        return view('admin.lokasiooh.list-wilayah', compact('lokasiooh'));
    }

    public function create()
    {
        $lokasioohs = new Lokasiooh(); 
        return view('admin.lokasiooh.create-lokasiooh', compact('lokasioohs'));
    }

    public function createLokasiooh(Request $request)
    {
        $request->validate([
            'nama_id' => 'required|min:3',
            'nama_en' => 'required|min:3',
            'deskripsi_lokasi_id' => 'required|min:10',
            'deskripsi_lokasi_en' => 'required|min:10',
            'koordinat' => 'required',
            'media' => 'required',
            'size' => 'required',
            'type' => 'required',
            'motor' => 'required',
            'mobil' => 'required',
            'wilayah' => 'required',
            'lighting' => 'required',
            'provinsi' => 'required',
            'gambar' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->status === 'Aktif') {
            $activeCount = Lokasiooh::where('status', 'Aktif')->count();
            if ($activeCount >= 3) {
                return redirect()->back()->withInput()->with('error', 'Maksimal 3 lokasi OOH yang dapat diaktifkan untuk ditampilkan di halaman beranda.');
            }
        }

        $lokasiooh = new Lokasiooh();
        
        // Simpan data multi-bahasa sebagai array
        $lokasiooh->nama = [
            'id' => $request->nama_id,
            'en' => $request->nama_en
        ];
        $lokasiooh->deskripsi_lokasi = [
            'id' => $request->deskripsi_lokasi_id,
            'en' => $request->deskripsi_lokasi_en
        ];

        $lokasiooh->koordinat = $request->koordinat;
        $lokasiooh->wilayah = $request->wilayah;
        $lokasiooh->provinsi = $request->provinsi;
        $lokasiooh->media = $request->media;
        $lokasiooh->size = $request->size;
        $lokasiooh->type = $request->type;
        $lokasiooh->motor = $request->motor;
        $lokasiooh->mobil = $request->mobil;
        $lokasiooh->lighting = $request->lighting;
        $lokasiooh->status = $request->status ?? 'Tidak aktif';
        $lokasiooh->availability = $request->availability ?? 'Available';

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
            
            // Simpan file ke storage/app/public/image_lokasiooh
            Storage::disk('public')->put('image_lokasiooh/' . $fileName, (string) $encoded);
            
            $lokasiooh->gambar = $fileName;
        }

        $lokasiooh->save();
        \Illuminate\Support\Facades\Cache::forget('homepage_data');
        return redirect('/admin/lokasiooh-wilayah')->with('success', 'Kamu berhasil menambahkan Lokasi baru!');
    }

    public function updateLokasiooh(Request $request, $id)
    {
        $lokasiooh = Lokasiooh::find($id);

        $request->validate([
            'nama_id' => 'required|min:3',
            'nama_en' => 'required|min:3',
            'deskripsi_lokasi_id' => 'required|min:10',
            'deskripsi_lokasi_en' => 'required|min:10',
            'koordinat' => 'required',
            'media' => 'required',
            'size' => 'required',
            'type' => 'required',
            'motor' => 'required',
            'mobil' => 'required',
            'lighting' => 'required',
            'provinsi' => 'required',
        ]);

        if ($request->status === 'Aktif') {
            $activeCount = Lokasiooh::where('status', 'Aktif')->where('id', '!=', $id)->count();
            if ($activeCount >= 3) {
                return redirect()->back()->withInput()->with('error', 'Maksimal 3 lokasi OOH yang dapat diaktifkan untuk ditampilkan di halaman beranda.');
            }
        }

        // Update data multi-bahasa
        $lokasiooh->nama = [
            'id' => $request->nama_id,
            'en' => $request->nama_en
        ];
        $lokasiooh->deskripsi_lokasi = [
            'id' => $request->deskripsi_lokasi_id,
            'en' => $request->deskripsi_lokasi_en
        ];

        $lokasiooh->koordinat = $request->koordinat;
        $lokasiooh->wilayah = $request->wilayah;
        $lokasiooh->media = $request->media;
        $lokasiooh->size = $request->size;
        $lokasiooh->type = $request->type;
        $lokasiooh->motor = $request->motor;
        $lokasiooh->mobil = $request->mobil;
        $lokasiooh->status = $request->status ?? 'Tidak aktif';
        $lokasiooh->availability = $request->availability ?? 'Available';
        $lokasiooh->provinsi = $request->provinsi;
        $lokasiooh->lighting = $request->lighting;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = uniqid() . '.webp';

            if ($lokasiooh->gambar) {
                Storage::disk('public')->delete('image_lokasiooh/' . $lokasiooh->gambar);
            }

            // Proses gambar menggunakan Intervention Image v3
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());
            
            // Resize jika lebar lebih dari 1920px
            $image->scaleDown(width: 1920);
            
            // Convert ke WebP dengan kualitas 80%
            $encoded = $image->toWebp(80);
            
            // Simpan file ke storage/app/public/image_lokasiooh
            Storage::disk('public')->put('image_lokasiooh/' . $fileName, (string) $encoded);
            
            $lokasiooh->gambar = $fileName;
        }

        $lokasiooh->save();
        \Illuminate\Support\Facades\Cache::forget('homepage_data');
        return redirect('/admin/lokasiooh-list/' . $lokasiooh->wilayah)->with('update', 'Kamu berhasil meng-update lokasi!');
    }

    public function delete($id)
    {
        $lokasiooh = Lokasiooh::find($id);

        if (!$lokasiooh) {
            return redirect()->back()->with('delete', 'Data lokasi tidak ditemukan.');
        }

        $wilayah = $lokasiooh->wilayah;

        if ($lokasiooh->gambar && Storage::disk('public')->exists('image_lokasiooh/' . $lokasiooh->gambar)) {
            Storage::disk('public')->delete('image_lokasiooh/' . $lokasiooh->gambar);
        }

        $lokasiooh->delete();
        \Illuminate\Support\Facades\Cache::forget('homepage_data');

        $remainingLocations = Lokasiooh::where('wilayah', $wilayah)->exists();

        if ($remainingLocations) {
            return redirect('/admin/lokasiooh-list/' . $wilayah)->with('delete', 'Kamu berhasil menghapus lokasi!');
        } else {
            return redirect('/admin/lokasiooh-wilayah')->with('delete', 'Kamu berhasil menghapus lokasi, tetapi wilayah tersebut kosong!');
        }
    }

    public function show($id)
{
    $lokasiooh = Lokasiooh::findOrFail($id);

    // Kasih pengaman di sini: Cek dulu datanya ada atau nggak
    $service = Service::find(16);
    if ($service) {
        $service->increment('click_count');
    }

    // Sisanya tetap sama
    [$latitude, $longitude] = explode(',', $lokasiooh->koordinat);
    return view('pages.lokasiooh.periklanan', compact('lokasiooh', 'latitude', 'longitude'));
}

    public function showwilayah()
    {
        $wilayah = Lokasiooh::selectRaw('LOWER(wilayah) as wilayah, COUNT(*) as jumlah')
            ->groupBy('wilayah')
            ->get();
        $LokasiOOHCount = Lokasiooh::count();
        return view('pages.lokasiooh.wilayah', compact('wilayah', 'LokasiOOHCount'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Untuk pencarian pada kolom JSON (Spatie), Laravel mendukung 'where' langsung
        $lokasiooh = Lokasiooh::where(function ($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi_lokasi', 'like', "%{$search}%")
                  ->orWhere('wilayah', 'like', "%{$search}%");
        })->get();

        foreach ($lokasiooh as $l) {
            $l->formattedLokasi = substr($l->deskripsi_lokasi, 0, 300) . '...';
        }

        return view('pages.our-locationooh', compact('lokasiooh'));
    }

    public function search2(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return redirect()->back()->with('status', 'error')->with('message', 'Masukkan kata kunci pencarian');
        }

        $lokasioohList = Lokasiooh::where('nama', 'like', "%{$search}%")
            ->orWhere('deskripsi_lokasi', 'like', "%{$search}%")
            ->orWhere('wilayah', 'like', "%{$search}%")
            ->get();

        return view('pages.our-locationooh', compact('lokasioohList', 'search'));
    }

    public function pilihOOH()
    {
        $tampil = Lokasiooh::where('status', 'aktif')->get();
        return view('admin.lokasiooh.index', compact('tampil'));
    }
}