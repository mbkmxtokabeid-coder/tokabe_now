<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portofolio;
use App\Models\PortofolioImage;
use App\Models\PortofolioVideo; 
use App\Models\PortofolioCategory; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PortofolioController extends Controller
{
    public function index()
    {
        $data = Portofolio::with(['images', 'videos', 'category'])->latest()->get();
        return view('admin.portofolio.index', compact('data'));
    }

    public function create()
    {
        $kategoris = PortofolioCategory::all();
        return view('admin.portofolio.create', compact('kategoris'));
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'judul_id'    => 'required|string|max:255',
            'judul_en'    => 'nullable|string|max:255',
            'deskripsi_id'=> 'nullable|string',
            'deskripsi_en'=> 'nullable|string',
            'kategori'    => 'required|exists:portofolio_categories,id',
            'klien'       => 'nullable|string|max:255',
            'tanggal'     => 'nullable|date',
            'lokasi'      => 'nullable|string|max:255',
            'images'      => 'required|array',
            'images.*'    => 'file|image|mimes:jpeg,png,jpg,webp|max:10240', 
            'videos'      => 'nullable|array',
            'videos.*'    => 'mimetypes:video/mp4|max:102400', 
        ]);

        $portofolio = Portofolio::create([
            'judul'       => json_encode(['id' => $request->judul_id, 'en' => $request->judul_en]),
            'deskripsi'   => json_encode(['id' => $request->deskripsi_id, 'en' => $request->deskripsi_en]),
            'kategori'    => $request->kategori, 
            'klien'       => $request->klien,
            'tanggal'     => $request->tanggal,
            'lokasi'      => $request->lokasi,
        ]);

        if ($request->hasFile('images')) {
            $manager = new ImageManager(new Driver());
            foreach ($request->file('images') as $image) {
                $filename = uniqid() . '.webp';
                
                // Proses gambar menggunakan Intervention Image v3
                $img = $manager->read($image->getRealPath());
                $img->scaleDown(width: 1920); // Resize if too large
                $encoded = $img->toWebp(80);
                
                $path = 'portofolio/' . $filename;
                Storage::disk('public')->put($path, (string) $encoded);

                PortofolioImage::create([
                    'portofolio_id' => $portofolio->id,
                    'image'         => $path,
                ]);
            }
        }

        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $videoFile) {
                $videoFilename = uniqid() . '.' . $videoFile->getClientOriginalExtension();
                $videoPath = $videoFile->storeAs('portofolio/videos', $videoFilename, 'public');

                PortofolioVideo::create([
                    'portofolio_id' => $portofolio->id,
                    'video_path'    => $videoPath,
                ]);
            }
        }

        return redirect()->route('portofolio.index')->with('success', 'Portofolio berhasil dibuat.');
    }

    public function edit($id)
    {
        $portofolio = Portofolio::with(['images', 'videos'])->findOrFail($id);
        $kategoris = PortofolioCategory::all();
        return view('admin.portofolio.edit', compact('portofolio', 'kategoris'));
    }

    // =========================
    // UPDATE (Refactored for Incremental Edit)
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_id'       => 'required|string|max:255',
            'judul_en'       => 'nullable|string|max:255',
            'deskripsi_id'   => 'nullable|string',
            'deskripsi_en'   => 'nullable|string',
            'kategori'       => 'required|exists:portofolio_categories,id',
            'images'         => 'nullable|array',
            'images.*'       => 'file|image|mimes:jpeg,png,jpg,webp|max:10240',
            'videos'         => 'nullable|array',
            'videos.*'       => 'mimetypes:video/mp4|max:102400',
            'delete_images'  => 'nullable|array',
            'delete_videos'  => 'nullable|array',
        ]);

        $portofolio = Portofolio::findOrFail($id);

        // 1. Update Basic Info
        $portofolio->update([
            'judul'       => json_encode(['id' => $request->judul_id, 'en' => $request->judul_en]),
            'deskripsi'   => json_encode(['id' => $request->deskripsi_id, 'en' => $request->deskripsi_en]),
            'kategori'    => $request->kategori,
            'klien'       => $request->klien,
            'tanggal'     => $request->tanggal,
            'lokasi'      => $request->lokasi,
        ]);

        // 2. Handle Deletions (Specific media marked with "X" in UI)
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imgId) {
                $img = PortofolioImage::where('id', $imgId)->where('portofolio_id', $id)->first();
                if ($img) {
                    Storage::disk('public')->delete($img->image);
                    $img->delete();
                }
            }
        }

        if ($request->has('delete_videos')) {
            foreach ($request->delete_videos as $vidId) {
                $vid = PortofolioVideo::where('id', $vidId)->where('portofolio_id', $id)->first();
                if ($vid) {
                    Storage::disk('public')->delete($vid->video_path);
                    $vid->delete();
                }
            }
        }

        // 3. Handle New Uploads (Append to existing)
        if ($request->hasFile('images')) {
            $manager = new ImageManager(new Driver());
            foreach ($request->file('images') as $image) {
                $filename = uniqid() . '.webp';
                
                // Proses gambar menggunakan Intervention Image v3
                $img = $manager->read($image->getRealPath());
                $img->scaleDown(width: 1920); // Resize if too large
                $encoded = $img->toWebp(80);
                
                $path = 'portofolio/' . $filename;
                Storage::disk('public')->put($path, (string) $encoded);

                PortofolioImage::create([
                    'portofolio_id' => $portofolio->id,
                    'image'         => $path,
                ]);
            }
        }

        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $videoFile) {
                $videoFilename = uniqid() . '.' . $videoFile->getClientOriginalExtension();
                $videoPath = $videoFile->storeAs('portofolio/videos', $videoFilename, 'public');

                PortofolioVideo::create([
                    'portofolio_id' => $portofolio->id,
                    'video_path'    => $videoPath,
                ]);
            }
        }

        return redirect()->route('portofolio.index')->with('success', 'Portofolio berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $portofolio = Portofolio::with(['images', 'videos'])->findOrFail($id);

        foreach ($portofolio->images as $img) {
            Storage::disk('public')->delete($img->image);
            $img->delete();
        }

        foreach ($portofolio->videos as $vid) {
            Storage::disk('public')->delete($vid->video_path);
            $vid->delete();
        }

        $portofolio->delete();

        return redirect()->route('portofolio.index')->with('success', 'Portofolio berhasil dihapus.');
    }
}