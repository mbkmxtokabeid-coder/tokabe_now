<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Photography;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Backtrace\Arguments\ReducedArgument\ReducedArgument;

class PhotographyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photography=Photography::all();

        return view('admin.photography.index', compact('photography'));
    }

    public function show()
    {
        $photography=Photography::all();
        Service::find(20)->increment('click_count');
        return view('pages.PhotoVideo.photovideolist', compact('photography'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'title_id'=>'required|min:5',
            'title_en'=>'required|min:5',
            'description_id'=>'required|min:10',
            'description_en'=>'required|min:10',
            'image_url'=>'required|image|mimes:png,jpg,jpeg,gif,webp|max:2048'
        ],[
            'title_id.required'=>'Title (ID) must have value, do not leave with blank!',
            'title_en.required'=>'Title (EN) must have value, do not leave with blank!',
            'title_id.min'=>'Title (ID) value minimum 5 characters!',
            'title_en.min'=>'Title (EN) value minimum 5 characters!',
            'description_id.required'=>'Description (ID) must have value, at least 10 characters!',
            'description_en.required'=>'Description (EN) must have value, at least 10 characters!',
            'description_id.min'=>'Minimum characters for description (ID) is 10 characters!',
            'description_en.min'=>'Minimum characters for description (EN) is 10 characters!',
            'image_url.required'=>'Image must have value, do not leave with blank!',
            'image_url.image'=>'Input file with image, do not others file!',
            'image_url.mimes'=>'Image format must be: png, jpeg, jpg, webp, and gif',
            'image_url.max'=>'Image file size maximum 2MB'
        ]);

        $photography=new Photography();
        $photography->title = [
            'id' => $request->title_id,
            'en' => $request->title_en
        ];
        $photography->description = [
            'id' => $request->description_id,
            'en' => $request->description_en
        ];

        //saving image data from user input
        if($request->hasFile('image_url')){
            $file = $request -> file('image_url');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension(); //Give file name before stored to database 

            $file->storeAs('public/image_photography', $fileName);

            $photography->image_url=$fileName;
        }

        $photography->save();

        return redirect('/admin/photography')->with('success', 'You have successfully saving new photography data');
    }

    public function destroy($id)
    {
    $photography = Photography::find($id);

    if ($photography) {
        // Hapus file gambar dari storage jika ada
        if ($photography->image_url && Storage::disk('public')->exists('image_photography/' . $photography->image_url)) {
            Storage::disk('public')->delete('image_photography/' . $photography->image_url);
        }

        // Hapus data dari database
        $photography->delete();

        return redirect('/admin/photography')->with('success', 'You have successfully deleted photography data');
    }

    return redirect('/admin/photography')->with('error', 'Photography data not found');
    }
    
    public function edit($id)
    {
        $photography=Photography::find($id);
        return view('admin.photography.update', compact('photography'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title_id'=>'required|min:5',
            'title_en'=>'required|min:5',
            'description_id'=>'required|min:10',
            'description_en'=>'required|min:10',
            //'image_url'=>'required|image|mimes:png,jpg,jpeg,gif,webp|max:2048'
        ]);

        $photography=Photography::findOrFail($id);

        $photography->title = [
            'id' => $request->title_id,
            'en' => $request->title_en
        ];
        $photography->description = [
            'id' => $request->description_id,
            'en' => $request->description_en
        ];

        if($request->hasFile('image_url')){
            $file=$request->file('image_url');
            $fileName=uniqid() . '.' . $file->getClientOriginalExtension();

            if($photography->image_url){
                $this->deleteImageFile($photography->image_url);
            }

            $file->storeAs('public/image_photography', $fileName);

            $photography->image_url=$fileName;
        }

        $photography->save();
        
        return redirect('admin/photography')->with('success', 'You have successfully updated photography data');
    }

    private function deleteImageFile($imagePath)
    {
        $fileName = basename($imagePath);

        $publicPath = public_path('storage/image_photography/' . $fileName);
        $storagePath = storage_path('app/public/image_photography/' . $fileName);

        if(file_exists($storagePath)){
            unlink($storagePath);
        }

        if(file_exists($publicPath)){
            unlink($publicPath);
        }
    }
}
