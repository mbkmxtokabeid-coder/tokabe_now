<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Legality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LegalityController extends Controller
{
    public function index()
    {
        $legalities = Legality::orderBy('sort_order')->get();
        return view('admin.legality.index', compact('legalities'));
    }

    public function create()
    {
        return view('admin.legality.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_id' => 'required',
            'name_en' => 'required',
            'description_id' => 'required',
            'description_en' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('image_legality', 'public');
        }

        Legality::create([
            'name_id' => $request->name_id,
            'name_en' => $request->name_en,
            'description_id' => $request->description_id,
            'description_en' => $request->description_en,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.legality.index')->with('success', 'Legality berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $legality = Legality::findOrFail($id);
        return view('admin.legality.edit', compact('legality'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_id' => 'required',
            'name_en' => 'required',
            'description_id' => 'required',
            'description_en' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        $legality = Legality::findOrFail($id);
        $imagePath = $legality->image;

        if ($request->hasFile('image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('image_legality', 'public');
        }

        $legality->update([
            'name_id' => $request->name_id,
            'name_en' => $request->name_en,
            'description_id' => $request->description_id,
            'description_en' => $request->description_en,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.legality.index')->with('success', 'Legality berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $legality = Legality::findOrFail($id);
        
        if ($legality->image && Storage::disk('public')->exists($legality->image)) {
            Storage::disk('public')->delete($legality->image);
        }
        
        $legality->delete();

        return redirect()->route('admin.legality.index')->with('success', 'Legality berhasil dihapus.');
    }
}
