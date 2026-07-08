<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AboutController extends Controller
{
    public function index()
    {
        $abouts = About::all();
        return view('admin.about.index', compact('abouts'));
    }

    public function edit($id)
    {
        $about = About::findOrFail($id);
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title_id' => 'required|string',
            'title_en' => 'required|string',
            'description_id' => 'required|string',
            'description_en' => 'required|string',
            'dooh_description_id' => 'required|string',
            'dooh_description_en' => 'required|string',
            'ooh_description_id' => 'required|string',
            'ooh_description_en' => 'required|string',
            'dooh_target' => 'required|integer',
            'ooh_target' => 'required|integer',
            'image_dooh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_ooh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $about = About::findOrFail($id);

        $title = [
            'id' => $request->title_id,
            'en' => $request->title_en,
        ];

        $description = [
            'id' => $request->description_id,
            'en' => $request->description_en,
        ];

        $dooh_description = [
            'id' => $request->dooh_description_id,
            'en' => $request->dooh_description_en,
        ];

        $ooh_description = [
            'id' => $request->ooh_description_id,
            'en' => $request->ooh_description_en,
        ];

        $about->title = $title;
        $about->description = $description;
        $about->dooh_description = $dooh_description;
        $about->ooh_description = $ooh_description;
        $about->dooh_target = $request->dooh_target;
        $about->ooh_target = $request->ooh_target;

        if ($request->hasFile('image_dooh')) {
            if ($about->image_dooh && !filter_var($about->image_dooh, FILTER_VALIDATE_URL) && Storage::disk('public')->exists('image_about/' . $about->image_dooh)) {
                Storage::disk('public')->delete('image_about/' . $about->image_dooh);
            }
            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->file('image_dooh')->getRealPath());
            $image->scaleDown(width: 1200);
            $encoded = $image->toWebp(70);
            
            $filename = time() . '_dooh.webp';
            Storage::disk('public')->put('image_about/' . $filename, (string) $encoded);
            $about->image_dooh = $filename;
        }

        if ($request->hasFile('image_ooh')) {
            if ($about->image_ooh && !filter_var($about->image_ooh, FILTER_VALIDATE_URL) && Storage::disk('public')->exists('image_about/' . $about->image_ooh)) {
                Storage::disk('public')->delete('image_about/' . $about->image_ooh);
            }
            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->file('image_ooh')->getRealPath());
            $image->scaleDown(width: 1200);
            $encoded = $image->toWebp(70);

            $filename = time() . '_ooh.webp';
            Storage::disk('public')->put('image_about/' . $filename, (string) $encoded);
            $about->image_ooh = $filename;
        }

        $about->save();

        return redirect()->route('admin.about.index')->with('success', 'About Us updated successfully');
    }
}
