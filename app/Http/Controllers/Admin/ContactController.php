<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class ContactController extends Controller
{
    public function index()
    {
        // Get the first contact or create a default one if table is empty
        $contact = Contact::first();
        if (!$contact) {
            $contact = Contact::create([
                'name' => 'Global Contact',
                'phone' => '628115239999',
                'message' => 'Halo Admin Tokabe',
            ]);
        }
        return view('admin.contact.index', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'location' => 'nullable|string',
            'message' => 'nullable|string',
        ]);

        $contact = Contact::findOrFail($id);
        
        if ($request->hasFile('cta_image')) {
            $request->validate(['cta_image' => 'image|mimes:jpeg,png,jpg,webp,svg|max:2048']);
            $file = $request->file('cta_image');
            
            // Jika file adalah SVG, jangan diubah oleh Intervention
            if ($file->getClientOriginalExtension() === 'svg' || $file->getClientMimeType() === 'image/svg+xml') {
                $path = $file->store('cta', 'public');
                $contact->cta_image = $path;
            } else {
                $fileName = uniqid() . '.webp';
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file->getRealPath());
                
                // Resize jika lebar lebih dari 1200px
                $image->scaleDown(width: 1200);
                
                $encoded = $image->toWebp(80);
                Storage::disk('public')->put('cta/' . $fileName, (string) $encoded);
                
                $contact->cta_image = 'cta/' . $fileName;
            }
        }

        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->location = $request->location;
        $contact->message = $request->message;
        $contact->save();

        return redirect()->route('contact-admin')->with('success', 'Pengaturan Kontak berhasil diperbarui');
    }
}
