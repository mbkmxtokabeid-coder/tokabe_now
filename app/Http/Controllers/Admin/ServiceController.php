<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Models\Service;
use App\Models\Heroe;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin.service.service-list', compact('services'));
    }

    public function edit($id)
    {
        $service = Service::find($id);
        return view('admin.service.edit-service', compact('service'));
    }

    public function create()
    {
        return view('admin.service.add-service');
    }

    public function createService(Request $request)
    {
        // 1. Validasi disesuaikan untuk menangkap inputan dua bahasa
        $request->validate([
            'judul_id' => 'required|min:3',
            'judul_en' => 'required|min:3',
            'deskripsi_id' => 'required|min:10',
            'deskripsi_en' => 'required|min:10',
            'gambar' => 'required|image|mimes:png,jpg,jpeg,gif|max:2048'
        ], [
            'judul_id.required' => 'Judul (ID) harus diisi',
            'judul_en.required' => 'Judul (EN) harus diisi',
            'deskripsi_id.required' => 'Deskripsi (ID) harus diisi',
            'deskripsi_en.required' => 'Deskripsi (EN) harus diisi',
            'judul_id.min' => 'Judul (ID) minimal 3 karakter',
            'deskripsi_id.min' => 'Deskripsi (ID) minimal 10 karakter',
            'gambar.mimes' => 'Format Gambar harus png/jpg/jpeg/gif',
            'gambar.image' => 'Harus foto/gambar',
            'gambar.max' => 'Ukuran maksimal 2Mb',
        ]);

        $service = new Service;
        
        // 2. Simpan sebagai array untuk Spatie Translatable
        $service->judul = [
            'id' => $request->judul_id,
            'en' => $request->judul_en
        ];

        $service->deskripsi = [
            'id' => $request->deskripsi_id,
            'en' => $request->deskripsi_en
        ];
        


        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = uniqid() . '.webp';

            // Proses gambar menggunakan Intervention Image v3
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());
            
            // Resize jika lebar lebih dari 1920px
            $image->scaleDown(width: 1920);
            
            // Convert ke WebP dengan kualitas 80%
            $encoded = $image->toWebp(80);
            
            // Simpan file ke storage/app/public/image_service
            Storage::disk('public')->put('image_service/' . $fileName, (string) $encoded);

            // Simpan nama file di database
            $service->gambar = $fileName;
        }

        $service->save();
        Cache::forget('homepage_data');
        return redirect('/admin/service-list')->with('success', 'Kamu berhasil menambahkan service baru!');
    }

    public function updateService(Request $request, $id)
    {
        $service = Service::find($id);

        // 1. Validasi disesuaikan untuk menangkap inputan dua bahasa
        $request->validate([
            'judul_id' => 'required|min:3',
            'judul_en' => 'required|min:3',
            'deskripsi_id' => 'required|min:10',
            'deskripsi_en' => 'required|min:10',
            'gambar' => 'image|mimes:png,jpg,jpeg,gif|max:2048'
        ], [
            'judul_id.required' => 'Judul (ID) harus diisi',
            'judul_en.required' => 'Judul (EN) harus diisi',
            'deskripsi_id.required' => 'Deskripsi (ID) harus diisi',
            'deskripsi_en.required' => 'Deskripsi (EN) harus diisi',
            'judul_id.min' => 'Judul (ID) minimal 3 karakter',
            'deskripsi_id.min' => 'Deskripsi (ID) minimal 10 karakter',
            'gambar.mimes' => 'Format Gambar harus png/jpg/jpeg/gif',
            'gambar.image' => 'Harus foto/gambar',
            'gambar.max' => 'Ukuran maksimal 2Mb',
        ]);

        // 2. Update data array untuk Spatie Translatable
        $service->judul = [
            'id' => $request->judul_id,
            'en' => $request->judul_en
        ];

        $service->deskripsi = [
            'id' => $request->deskripsi_id,
            'en' => $request->deskripsi_en
        ];



        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = uniqid() . '.webp';

            // Hapus gambar lama jika ada
            if ($service->gambar && Storage::disk('public')->exists('image_service/' . $service->gambar)) {
                Storage::disk('public')->delete('image_service/' . $service->gambar);
            }

            // Proses gambar menggunakan Intervention Image v3
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());
            
            // Resize jika lebar lebih dari 1920px
            $image->scaleDown(width: 1920);
            
            // Convert ke WebP dengan kualitas 80%
            $encoded = $image->toWebp(80);
            
            // Simpan file baru ke storage/app/public/image_service
            Storage::disk('public')->put('image_service/' . $fileName, (string) $encoded);

            // Simpan nama file di database
            $service->gambar = $fileName;
        }

        $service->save();
        Cache::forget('homepage_data');
        return redirect('/admin/service-list')->with('update', 'Kamu berhasil meng-update service!');
    }

    public function destroy($id)
    {
        $service = Service::find($id);
        if ($service) {
            // Hapus file gambar dari storage jika ada
            if ($service->gambar && Storage::disk('public')->exists('image_service/' . $service->gambar)) {
                Storage::disk('public')->delete('image_service/' . $service->gambar);
            }

            // Hapus data dari database
            $service->delete();
            Cache::forget('homepage_data');

            return redirect('/admin/service-list')->with('success', 'You have successfully deleted service data');
        }

        return redirect('/admin/service-list')->with('error', 'Service data not found');
    }

    public function show($id)
    {
        // Cari service berdasarkan ID
        $service = Service::find($id);

        // Pastikan data ditemukan
        if (!$service) {
            abort(404, 'Service not found');
        }

        // Mapping ID baru ke route
        $routes = [
            1 => route('ourLocation', ['billboard' => 'DOOH']),  // Link untuk DOOH
            2 => route('showwilayah'),                           // Link untuk OOH
            3 => route('brand'),                                 // Link untuk Event & Brand Activity
            4 => route('showPhoto')                              // Link untuk Photography
        ];

        // Ambil link berdasarkan ID, atau gunakan link default
        $serviceLinks = $routes[$service->id] ?? route('home');

        // Mengembalikan tampilan dengan data yang relevan
        return view('pages.service.periklanan', compact('service', 'serviceLinks'));
    }

    public function brand(Request $request)
    {
        $brands = Brand::all();
        $activeTab = (int) $request->query('tab', 0); // default 0 kalau nggak ada query
        
        // Ubah ID 18 menjadi 3 menyesuaikan database yang baru
        $service = Service::find(3);
        if ($service) {
            $service->increment('click_count');
        }
        
        return view('pages.service.brand-activity', compact('brands','activeTab'));
    }

    public function orderClickIncrement(Request $request) 
    {
        $service = Service::find($request->service_id);
        if ($service) {
            $service->increment('order_count');
        }
    return response()->json(['success' => true]);
    }

}