<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;
use App\Models\Lokasi;
use App\Models\Heroe;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasis = Lokasi::all();
        return view('admin.lokasi.lokasi-list', compact('lokasis'));
    }

    public function edit($id)
    {
        $lokasi = Lokasi::all();
        $lokasis = Lokasi::find($id);
        return view('admin.lokasi.edit-lokasi', compact('lokasi', 'lokasis'));
    }

    public function create()
    {
        $lokasis = new Lokasi(); 
        return view('admin.lokasi.add-lokasi', compact('lokasis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'nama_id' => 'required|min:3',
                'nama_en' => 'required|min:3',
                'tagline' => 'required',
                'deskripsi_lokasi_id' => 'required|min:10',
                'deskripsi_lokasi_en' => 'required|min:10',
                'koordinat' => 'required',
                'provinsi'=> 'required',
                'media' => 'required',
                'size' => 'required',
                'type' => 'required',
                'motor' => 'required',
                'mobil' => 'required',
                'duration' => 'required',
                'hour' => 'required',
                'spot' => 'required',
                'brand' => 'required',
                'display' => 'required',
                'gambar' => 'required|image|max:5048',
            ],
            [
                'nama_id.required' => 'Nama (ID) harus diisi',
                'nama_en.required' => 'Nama (EN) harus diisi',
                'tagline.required' => 'Tagline harus diisi',
                'deskripsi_lokasi_id.required' => 'Deskripsi (ID) harus diisi',
                'deskripsi_lokasi_en.required' => 'Deskripsi (EN) harus diisi',
                'gambar.required' => 'Gambar harus diisi',
                'nama_id.min' => 'Nama (ID) minimal 3 karakter',
                'deskripsi_lokasi_id.min' => 'Deskripsi (ID) minimal 10 karakter',
                // dst...
            ]
        );

        if ($request->status === 'Aktif') {
            $activeCount = Lokasi::where('status', 'Aktif')->count();
            if ($activeCount >= 3) {
                return redirect()->back()->withInput()->with('error', 'Maksimal 3 lokasi DOOH yang dapat diaktifkan untuk ditampilkan di halaman beranda.');
            }
        }

        $lokasi = new Lokasi();
        $lokasi->nama = json_encode([
            'id' => $request->nama_id,
            'en' => $request->nama_en,
        ]);
        $lokasi->tagline = $request->tagline;
        $lokasi->deskripsi_lokasi = json_encode([
            'id' => $request->deskripsi_lokasi_id,
            'en' => $request->deskripsi_lokasi_en,
        ]);
        $lokasi->koordinat = $request->koordinat;
        $lokasi->provinsi = $request->provinsi;
        $lokasi->media = $request->media;
        $lokasi->size = $request->size;
        $lokasi->type = $request->type;
        $lokasi->motor = $request->motor;
        $lokasi->mobil = $request->mobil;
        $lokasi->duration = $request->duration;
        $lokasi->hour = $request->hour;
        $lokasi->spot = $request->spot;
        $lokasi->brand = $request->brand;
        $lokasi->display = $request->display;
        $lokasi->status = $request->status ?? 'Tidak aktif';
        $lokasi->availability = $request->availability ?? 'Available';

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
            
            // Simpan file ke storage/app/public/image_lokasi
            Storage::disk('public')->put('image_lokasi/' . $fileName, (string) $encoded);
            
            $lokasi->gambar = $fileName;
        }

        $lokasi->save();
        \Illuminate\Support\Facades\Cache::forget('homepage_data');

        return redirect()->route('lokasi-list')->with('success', 'Lokasi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $lokasi = Lokasi::find($id);

        $validated = $request->validate([
            'nama_id' => 'required|min:3',
            'nama_en' => 'required|min:3',
            'tagline' => 'required',
            'deskripsi_lokasi_id' => 'required|min:10',
            'deskripsi_lokasi_en' => 'required|min:10',
            'koordinat' => 'required',
            'provinsi' => 'required',
            'media' => 'required',
            'size' => 'required',
            'type' => 'required',
            'motor' => 'required',
            'mobil' => 'required',
            'duration' => 'required',
            'hour' => 'required',
            'spot' => 'required',
            'brand' => 'required',
            'display' => 'required',
            // 'gambar' => 'required|image|mimes:png,jpg,jpeg|max:102400',
        ]);

        if ($request->status === 'Aktif') {
            $activeCount = Lokasi::where('status', 'Aktif')->where('id', '!=', $id)->count();
            if ($activeCount >= 3) {
                return redirect()->back()->withInput()->with('error', 'Maksimal 3 lokasi DOOH yang dapat diaktifkan untuk ditampilkan di halaman beranda.');
            }
        }

        $lokasi->nama = json_encode([
            'id' => $request->nama_id,
            'en' => $request->nama_en,
        ]);
        $lokasi->tagline = $request->tagline;
        $lokasi->koordinat = $request->koordinat;
        $lokasi->provinsi = $request->provinsi;
        $lokasi->media = $request->media;
        $lokasi->size = $request->size;
        $lokasi->type = $request->type;
        $lokasi->motor = $request->motor;
        $lokasi->mobil = $request->mobil;
        $lokasi->duration = $request->duration;
        $lokasi->hour = $request->hour;
        $lokasi->spot = $request->spot;
        $lokasi->brand = $request->brand;
        $lokasi->display = $request->display;
        $lokasi->deskripsi_lokasi = json_encode([
            'id' => $request->deskripsi_lokasi_id,
            'en' => $request->deskripsi_lokasi_en,
        ]);
        $lokasi->status = $request->status ?? 'Tidak aktif';
        $lokasi->availability = $request->availability ?? 'Available';

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = uniqid() . '.webp';

            // Hapus gambar lama jika ada
            if ($lokasi->gambar) {
                Storage::disk('public')->delete('image_lokasi/' . $lokasi->gambar);
            }

            // Proses gambar menggunakan Intervention Image v3
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());
            
            // Resize jika lebar lebih dari 1920px
            $image->scaleDown(width: 1920);
            
            // Convert ke WebP dengan kualitas 80%
            $encoded = $image->toWebp(80);
            
            // Simpan file ke storage/app/public/image_lokasi
            Storage::disk('public')->put('image_lokasi/' . $fileName, (string) $encoded);

            // Simpan nama file di database
            $lokasi->gambar = $fileName;
        }

        $lokasi->save();
        \Illuminate\Support\Facades\Cache::forget('homepage_data');
        return redirect()->route('lokasi-list')->with('success', 'Kamu berhasil meng-update lokasi!');
    }

    public function delete($id)
    {
        $lokasi = Lokasi::find($id);
        
        if ($lokasi) {
            // Hapus file gambar dari storage jika ada
            if ($lokasi->gambar && Storage::exists('public/image_lokasi/' . $lokasi->gambar)) {
                Storage::delete('public/image_lokasi/' . $lokasi->gambar);
            }

            // Hapus data dari database
            $lokasi->delete();
            \Illuminate\Support\Facades\Cache::forget('homepage_data');

            return redirect('/admin/lokasi-list')->with('success', 'You have successfully deleted DOOH data');
        }

        return redirect('/admin/lokasi-list')->with('error', 'DOOH data not found');
    }

    public function show($nama)
    {
        $lokasi = Lokasi::where('nama', $nama)->first();
        
        if (!$lokasi) {
            session()->flash('status', 'error');
            session()->flash('message', 'Data Tidak Ditemukan');
            return redirect()->back();
        }

        Service::find(15)->increment('click_count');

        // Pisahkan koordinat menjadi latitude dan longitude dengan pengecekan (FIX ERROR)
        $koordinatArray = explode(',', $lokasi->koordinat);
        
        if (count($koordinatArray) >= 2) {
            $latitude = trim($koordinatArray[0]);
            $longitude = trim($koordinatArray[1]);
        } else {
            // Memberikan nilai default jika format koordinat di database salah/kosong
            $latitude = '-0.947183'; // Contoh default (Bisa kamu ganti '0')
            $longitude = '100.360123'; // Contoh default (Bisa kamu ganti '0')
        }

        // Tambahkan latitude dan longitude ke dalam array untuk dikirim ke view
        return view('pages.lokasi.periklanan', compact('lokasi', 'latitude', 'longitude'));
    }

    // Menampilkan data yg aktif untuk halaman home
    public function tampilDOOH()
    {
        // FIX BUG: Sebelumnya lupa memakai ->get() sehingga data tidak terambil
        $lokasis = Lokasi::where('status', 'Aktif')->get(); 

        return view('admin.lokasi.lokasi-list', compact('lokasis')); // view pakai punya home
    }
}