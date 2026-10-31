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
        $lokasiooh = Lokasiooh::whereRaw('LOWER(wilayah) = ?', [strtolower(trim($wilayah))])->get();
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
            'type' => 'required|in:Horizontal,Vertical',
            'motor' => 'nullable|string|max:255',
            'mobil' => 'nullable|string|max:255',
            'daily_total_traffic' => 'nullable|string|max:255',
            'wilayah' => 'required',
            'lighting' => 'required',
            'provinsi' => 'required',
            'gambar' => 'required|image|max:10240',
        ]);

        if ($request->status === 'Aktif') {
            $activeCount = Lokasiooh::where('status', 'Aktif')->count();
            if ($activeCount >= 3) {
                return redirect()->back()->withInput()->with('error', 'Maksimal 3 lokasi OOH yang dapat diaktifkan untuk ditampilkan di halaman beranda.');
            }
        }

        $lokasiooh = new Lokasiooh();
        
        $lokasiooh->nama = [
            'id' => $request->nama_id,
            'en' => $request->nama_en
        ];
        $lokasiooh->deskripsi_lokasi = [
            'id' => $request->deskripsi_lokasi_id,
            'en' => $request->deskripsi_lokasi_en
        ];

        $lokasiooh->koordinat = $request->koordinat;
        $lokasiooh->wilayah = trim($request->wilayah);
        $lokasiooh->provinsi = $request->provinsi;
        $lokasiooh->media = $request->media;
        $lokasiooh->size = $request->size;
        $lokasiooh->type = $request->type;
        [$lokasiooh->motor, $lokasiooh->mobil, $lokasiooh->daily_total_traffic] = $this->resolveTrafficProportion($request);
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
        return redirect('/admin/lokasiooh-list/' . trim($lokasiooh->wilayah))->with('success', 'Kamu berhasil menambahkan Lokasi baru!');
    }

    public function updateLokasiooh(Request $request, $id)
    {
        $lokasiooh = Lokasiooh::findOrFail($id);

        $request->validate([
            'nama_id' => 'required|min:3',
            'nama_en' => 'required|min:3',
            'deskripsi_lokasi_id' => 'required|min:10',
            'deskripsi_lokasi_en' => 'required|min:10',
            'koordinat' => 'required',
            'wilayah' => 'required',
            'media' => 'required',
            'size' => 'required',
            'type' => 'required|in:Horizontal,Vertical',
            'motor' => 'nullable|string|max:255',
            'mobil' => 'nullable|string|max:255',
            'daily_total_traffic' => 'nullable|string|max:255',
            'lighting' => 'required',
            'provinsi' => 'required',
            'gambar' => 'nullable|image|max:10240',
        ]);

        if ($request->status === 'Aktif') {
            $activeCount = Lokasiooh::where('status', 'Aktif')->where('id', '!=', $id)->count();
            if ($activeCount >= 3) {
                return redirect()->back()->withInput()->with('error', 'Maksimal 3 lokasi OOH yang dapat diaktifkan untuk ditampilkan di halaman beranda.');
            }
        }

        $lokasiooh->nama = [
            'id' => $request->nama_id,
            'en' => $request->nama_en
        ];
        $lokasiooh->deskripsi_lokasi = [
            'id' => $request->deskripsi_lokasi_id,
            'en' => $request->deskripsi_lokasi_en
        ];

        $lokasiooh->koordinat = $request->koordinat;
        $lokasiooh->wilayah = trim($request->wilayah);
        $lokasiooh->media = $request->media;
        $lokasiooh->size = $request->size;
        $lokasiooh->type = $request->type;
        [$lokasiooh->motor, $lokasiooh->mobil, $lokasiooh->daily_total_traffic] = $this->resolveTrafficProportion($request, $lokasiooh);
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
        return redirect('/admin/lokasiooh-list/' . trim($lokasiooh->wilayah))->with('success', 'Kamu berhasil meng-update lokasi!');
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

    /**
     * Hitung otomatis dua arah:
     * 1) Jika Motor/Mobil diisi -> Total Kendaraan Harian = Motor + Mobil
     * 2) Jika Total Kendaraan Harian diisi -> Motor = 80%, Mobil = 20% (tanpa desimal, akurat 100%)
     */
    private function resolveTrafficProportion(Request $request, ?Lokasiooh $existing = null): array
    {
        $totalRaw = trim((string) ($request->daily_total_traffic ?? ''));
        $motorRaw = trim((string) ($request->motor ?? ''));
        $mobilRaw = trim((string) ($request->mobil ?? ''));

        $isTotalEmpty = $totalRaw === '' || $totalRaw === '-';
        $isMotorEmpty = $motorRaw === '' || $motorRaw === '-';
        $isMobilEmpty = $mobilRaw === '' || $mobilRaw === '-';

        $motorOrMobilChanged = $existing
            && ($motorRaw !== trim((string) ($existing->motor ?? '')) || $mobilRaw !== trim((string) ($existing->mobil ?? '')))
            && $totalRaw === trim((string) ($existing->daily_total_traffic ?? ''));

        $totalChanged = $existing
            && $totalRaw !== trim((string) ($existing->daily_total_traffic ?? ''))
            && $motorRaw === trim((string) ($existing->motor ?? ''))
            && $mobilRaw === trim((string) ($existing->mobil ?? ''));

        // Arah 1: Motor atau Mobil diisi/diubah -> Hitung Total = Motor + Mobil
        if ((!$isMotorEmpty || !$isMobilEmpty) && ($isTotalEmpty || $motorOrMobilChanged)) {
            $motorDigits = preg_replace('/[^0-9]/', '', $motorRaw);
            $mobilDigits = preg_replace('/[^0-9]/', '', $mobilRaw);
            $motorNum = $motorDigits !== '' ? (int) $motorDigits : 0;
            $mobilNum = $mobilDigits !== '' ? (int) $mobilDigits : 0;
            $totalNum = $motorNum + $mobilNum;

            if ($totalNum > 0) {
                $useDotSeparator = str_contains($motorRaw, '.') || str_contains($mobilRaw, '.');
                $totalRaw = '± ' . ($useDotSeparator ? number_format($totalNum, 0, ',', '.') : (string) $totalNum);
            }
        }
        // Arah 2: Total diisi/diubah -> Hitung 80% Motor & 20% Mobil
        elseif (!$isTotalEmpty && (($isMotorEmpty && $isMobilEmpty) || $totalChanged)) {
            $digits = preg_replace('/[^0-9]/', '', $totalRaw);
            $totalNum = $digits !== '' ? (int) $digits : 0;

            if ($totalNum > 0) {
                $motorNum = (int) round($totalNum * 0.80);
                $mobilNum = $totalNum - $motorNum;

                $useDotSeparator = str_contains($totalRaw, '.');

                $motorRaw = '± ' . ($useDotSeparator ? number_format($motorNum, 0, ',', '.') : (string) $motorNum);
                $mobilRaw = '± ' . ($useDotSeparator ? number_format($mobilNum, 0, ',', '.') : (string) $mobilNum);
            }
        }

        $ensurePlusMinus = function (string $val): string {
            $val = trim(str_replace('+-', '', $val));
            if ($val === '' || $val === '-') {
                return '';
            }
            $val = ltrim(str_replace('±', '', $val));
            return '± ' . $val;
        };

        $motorRaw = $ensurePlusMinus($motorRaw);
        $mobilRaw = $ensurePlusMinus($mobilRaw);
        $totalRaw = $ensurePlusMinus($totalRaw);

        return [$motorRaw, $mobilRaw, $totalRaw !== '' ? $totalRaw : null];
    }
}