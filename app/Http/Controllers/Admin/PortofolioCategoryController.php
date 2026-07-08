<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortofolioCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortofolioCategoryController extends Controller
{
    public function index()
    {
        $portofolio_categories = PortofolioCategory::latest()->get();
        return view('admin.portofolio_categories.index', compact('portofolio_categories'));
    }

    public function create()
    {
        return view('admin.portofolio_categories.create');
    }

    // ===================== STORE =====================
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori_id' => 'required|string|max:100',
            'nama_kategori_en' => 'nullable|string|max:100',
            'tanggal'         => 'nullable|date',
            'klien'           => 'nullable|string|max:255',
            'lokasi'          => 'nullable|string|max:255',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // upload gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('kategori', 'public');
        }

        $nama_kategori = json_encode(['id' => $request->nama_kategori_id, 'en' => $request->nama_kategori_en]);

        PortofolioCategory::create([
            'nama_kategori' => $nama_kategori,
            'tanggal'       => $request->tanggal,
            'klien'         => $request->klien,
            'lokasi'        => $request->lokasi,
            'image'         => $imagePath,
        ]);

        return redirect()
            ->route('portofolio_categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    // ===================== EDIT =====================
    public function edit($id)
    {
        $category = PortofolioCategory::findOrFail($id);
        return view('admin.portofolio_categories.edit', compact('category'));
    }

    // ===================== UPDATE =====================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori_id' => 'required|string|max:100',
            'nama_kategori_en' => 'nullable|string|max:100',
            'tanggal'       => 'nullable|date',
            'klien'         => 'nullable|string|max:255',
            'lokasi'        => 'nullable|string|max:255',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $category = PortofolioCategory::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $category->image = $request->file('image')->store('kategori', 'public');
        }

        $category->update([
            'nama_kategori' => json_encode(['id' => $request->nama_kategori_id, 'en' => $request->nama_kategori_en]),
            'tanggal'       => $request->tanggal,
            'klien'         => $request->klien,
            'lokasi'        => $request->lokasi,
        ]);

        return redirect()
            ->route('portofolio_categories.index')
            ->with('success', 'Kategori portofolio berhasil diperbarui!');
    }

    // ===================== DELETE =====================
    public function destroy($id)
    {
        $category = PortofolioCategory::findOrFail($id);

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()
            ->route('portofolio_categories.index')
            ->with('delete', 'Kategori portofolio berhasil dihapus!');
    }
}
