<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesan;
class HomeController extends Controller
{
    /**
     * Resolve a multilingual field (array with 'id'/'en' keys, or plain string) to a single string.
     */
    private function resolveText(mixed $value, string $fallback = ''): string
    {
        if ($value === null || $value === '') return $fallback;
        if (is_string($value)) return $value;
        if (is_array($value)) {
            return ($value[app()->getLocale()] ?? '')
                ?: ($value['id'] ?? '')
                ?: ($value['en'] ?? '')
                ?: (collect($value)->first() ?? $fallback);
        }
        return $fallback;
    }
    public function servicesIndex()
    {
        $services = \App\Models\Service::all();
        return view('pages.service.index', compact('services'));
    }

    public function periklananIndex(Request $request, $id)
    {
        $service = \App\Models\Service::find($id);
        if (!$service) {
            $service = (object)[
                'id' => $id,
                'judul' => $id == 1 ? 'DOOH / Videotron' : ($id == 2 ? 'OOH / Billboard / Baliho' : 'Services'),
                'deskripsi' => '',
            ];
        }
        $search = $request->query('search');
        $province = $request->query('provinsi');
        
        $userAgent = $request->userAgent() ?? '';
        $isMobile = preg_match("/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i", $userAgent);
        $limit = 12;
        
        $items = collect([]);
        $allProvinces = collect();

        if ($id == 1) { // DOOH
            $allProvinces = \App\Models\Lokasi::pluck('provinsi')->filter()->map(function($p) { return str_replace('Sumatra', 'Sumatera', $p); })->unique()->sort()->values();
            
            $query = \App\Models\Lokasi::query();
            
            if ($province) {
                $dbProvinceSearch = str_replace('Sumatera', 'Sumatra', $province);
                $query->where(function($q) use ($province, $dbProvinceSearch) {
                    $q->where('provinsi', 'LIKE', "%{$province}%")
                      ->orWhere('provinsi', 'LIKE', "%{$dbProvinceSearch}%");
                });
            }
            
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'LIKE', "%{$search}%")
                      ->orWhere('provinsi', 'LIKE', "%{$search}%")
                      ->orWhere('deskripsi_lokasi', 'LIKE', "%{$search}%")
                      ->orWhere('tagline', 'LIKE', "%{$search}%");
                });
            }
            $items = $query->paginate($limit);
            
            if ($items->isEmpty() && !$search && !$province) {
                $items = collect([
                    (object)[
                        'id' => 1,
                        'title' => 'Putri Hijau Street, Next To GMP Building',
                        'description' => 'The ONE and ONLY in Medan two screens Videotron, connecting vertical and horizontal motion also HIGHLIGHTS the SYNCHRONIZED MOTION.',
                        'image' => 'https://images.unsplash.com/photo-1542204165-65bf26472b9b?q=80&w=600&auto=format&fit=crop',
                    ],
                    (object)[
                        'id' => 2,
                        'title' => 'View From Jl. Gatot Subroto (Bundaran SIB) Medan',
                        'description' => 'An ICONIC CURVE LED on Medan SIB Tower! Display for DOOH Advertising, visually on the STRIKING CURVE LED SCREEN on or around prominent clock tower.',
                        'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=600&auto=format&fit=crop',
                    ]
                ]);
            } else {
                $items->getCollection()->transform(function($i) {
                    $title = $this->resolveText($i->nama, $i->provinsi . ' - ' . $i->media);
                    $desc  = $this->resolveText($i->deskripsi_lokasi) ?: $this->resolveText($i->tagline);
                    return (object)[
                        'id'         => $i->id,
                        'title'      => $title,
                        'description'=> $desc,
                        'image'      => $i->gambar ? asset('storage/image_lokasi/' . $i->gambar) : 'https://images.unsplash.com/photo-1542204165-65bf26472b9b?q=80&w=600&auto=format&fit=crop',
                        'detail_url' => route('dooh.detail', $i->id),
                        'kota'       => $i->kota,
                        'media'      => $i->media,
                        'size'       => $i->size,
                        'availability' => $i->availability ?? 'Available',
                    ];
                });
            }
        } elseif ($id == 2) { // OOH
            $allProvinces = \App\Models\Lokasiooh::pluck('provinsi')->filter()->map(function($p) { return str_replace('Sumatra', 'Sumatera', $p); })->unique()->sort()->values();
            
            $query = \App\Models\Lokasiooh::query();
            
            if ($province) {
                $dbProvinceSearch = str_replace('Sumatera', 'Sumatra', $province);
                $query->where(function($q) use ($province, $dbProvinceSearch) {
                    $q->where('provinsi', 'LIKE', "%{$province}%")
                      ->orWhere('provinsi', 'LIKE', "%{$dbProvinceSearch}%");
                });
            }
            
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'LIKE', "%{$search}%")
                      ->orWhere('wilayah', 'LIKE', "%{$search}%")
                      ->orWhere('provinsi', 'LIKE', "%{$search}%")
                      ->orWhere('deskripsi_lokasi', 'LIKE', "%{$search}%");
                });
            }
            $items = $query->paginate($limit);
            
            if ($items->isEmpty() && !$search && !$province) {
                $items = collect([
                    (object)[
                        'id' => 1,
                        'title' => 'SUPER LOCATION OOH Billboards',
                        'description' => 'Premium traditional outdoor advertising placed in highly strategic intersections across the city.',
                        'image' => 'https://images.unsplash.com/photo-1556761175-b413da4baf72?q=80&w=600&auto=format&fit=crop',
                    ]
                ]);
            } else {
                $items->getCollection()->transform(function($i) {
                    $title = $this->resolveText($i->nama, $i->wilayah ?? '');
                    $desc  = $this->resolveText($i->deskripsi_lokasi) ?: $this->resolveText($i->tagline);
                    $imgFile = $i->getRawOriginal('gambar') ?? '';
                    return (object)[
                        'id'         => $i->id,
                        'title'      => $title,
                        'description'=> $desc,
                        'image'      => (!empty($imgFile)) ? asset('storage/image_lokasiooh/' . $imgFile) : 'https://images.unsplash.com/photo-1556761175-b413da4baf72?q=80&w=600&auto=format&fit=crop',
                        'detail_url' => route('ooh.detail', $i->id),
                        'kota'       => $i->wilayah ?? $i->kota,
                        'media'      => $i->tipe ?? $i->type,
                        'size'       => $i->ukuran ?? $i->size,
                        'availability' => $i->availability ?? 'Available',
                    ];
                });
            }
        }

        return view('services.show', compact('service', 'items', 'search', 'province', 'allProvinces'));
    }

    public function showService(Request $request, $id)
    {
        $service = \App\Models\Service::find($id);
        if (!$service) {
            $service = (object)[
                'id' => $id,
                'judul' => $id == 1 ? 'DOOH / Videotron' : ($id == 2 ? 'OOH / Billboard / Baliho' : 'Services'),
                'deskripsi' => '',
            ];
        }
        $search = $request->query('search');
        
        // Detect if user is on a mobile device (excluding tablets if possible) to set pagination limit
        $userAgent = $request->userAgent() ?? '';
        $isMobile = preg_match("/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i", $userAgent);
        $limit = 12;
        
        $items = collect([]);

        // Handle each service data
        if ($id == 3) { // Photography
            $query = \App\Models\Photography::query();
            if ($search) {
                $query->where('title', 'LIKE', "%{$search}%");
            }
            $items = $query->get();
            
            if ($items->isEmpty() && !$search) {
                $items = collect([
                    (object)[
                        'id' => 1,
                        'title' => 'Professional Product Photography',
                        'description' => 'High-end studio photography tailored for modern product catalogs and advertisements.',
                        'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=600&auto=format&fit=crop',
                    ]
                ]);
            } else {
                $items = $items->map(function($i) {
                    $title = $this->resolveText($i->title, 'Photography Session');
                    $desc  = $this->resolveText($i->description, 'Professional photography services by Tokabe.');
                    return (object)[
                        'id'         => $i->id,
                        'title'      => $title,
                        'description'=> $desc,
                        'image'      => $i->image_url ? asset('storage/image_photography/' . $i->image_url) : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=600&auto=format&fit=crop',
                    ];
                });
            }
        } elseif ($id == 4) { // Event & Brand Activity
            $query = \App\Models\Brand::query();
            if ($search) {
                $query->where('nama', 'LIKE', "%{$search}%");
            }
            $items = $query->get();
            
            if ($items->isEmpty() && !$search) {
                $items = collect([
                    (object)[
                        'id' => 1,
                        'title' => 'Participant Arrangement for Marathons',
                        'description' => 'Comprehensive crowd control, participant tagging, and event synchronization for large-scale outdoor events.',
                        'image' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?q=80&w=600&auto=format&fit=crop',
                    ]
                ]);
            } else {
                $items = $items->map(function($i) {
                    return (object)[
                        'id'         => $i->id,
                        'title'      => $this->resolveText($i->judul),
                        'description'=> $this->resolveText($i->deskripsi),
                        'image'      => $i->gambar ? asset('storage/image_brand/' . $i->gambar) : 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?q=80&w=600&auto=format&fit=crop',
                    ];
                });
            }
        } else {
            // For any other dynamic service, render the detail page
            
            // Fetch Categories and Details for this specific service
            $categories = \App\Models\ServiceCategory::with('serviceDetails')->where('service_id', $service->id)->get();
            
            $brands = $categories->map(function($cat) {
                $firstDetail = $cat->serviceDetails->where('tipe_card', 'main')->first();
                $otherDetails = $cat->serviceDetails->where('tipe_card', 'sub');
                
                return (object)[
                    'id' => $cat->id,
                    'tab_title' => $cat->nama,
                    'nama_brand' => is_array($cat->nama) ? ($cat->nama['id'] ?? '') : $cat->nama,
                    'judul' => $firstDetail ? $firstDetail->judul : '',
                    'deskripsi' => $firstDetail ? $firstDetail->deskripsi : '',
                    'gambar' => $firstDetail && $firstDetail->gambar ? asset('storage/service_details/' . $firstDetail->gambar) : 'https://images.unsplash.com/photo-1542204165-65bf26472b9b?q=80&w=1200&auto=format&fit=crop',
                    'detail' => $otherDetails->map(function($d) {
                        return [
                            'title' => $d->judul,
                            'description' => $d->deskripsi,
                            'image_url' => $d->gambar ? asset('storage/service_details/' . $d->gambar) : 'https://images.unsplash.com/photo-1542204165-65bf26472b9b?q=80&w=400&auto=format&fit=crop'
                        ];
                    })->toArray()
                ];
            });
            $activeTab = (int) $request->query('tab', 0);

            // Get Portfolio Data
            $portofolioCategories = \App\Models\PortofolioCategory::all();
            $portofolios = \App\Models\Portofolio::with('firstImage')->latest()->get();

            return view('services.detail', compact('service', 'brands', 'activeTab', 'portofolioCategories', 'portofolios'));
        }

        return view('services.show', compact('service', 'items', 'search'));
    }

    public function showOohDetail($id)
    {
        $lokasiooh = \App\Models\Lokasiooh::find($id);
        
        if (!$lokasiooh) {
            // Dummy fallback if ID doesn't exist in DB (e.g. dummy card 3)
            $lokasiooh = (object)[
                'id' => $id,
                'nama' => 'Jl. S. Parman (Cambridge Area)',
                'deskripsi_lokasi' => 'This is a premium dummy location shown because there are only ' . \App\Models\Lokasiooh::count() . ' records in the database.',
                'gambar' => null,
                'koordinat' => '3.5852,98.6652',
                'mobil' => '120,000',
                'motor' => '85,000',
                'media' => 'Videotron',
                'type' => 'Horizontal',
                'size' => '4m x 6m',
                'lighting' => 'LED',
            ];
            return view('services.ooh-detail', compact('lokasiooh'));
        }

        // Ensure translations are handled if needed, though view can also handle it
        $lokasiooh->nama = is_array($lokasiooh->nama) ? ($lokasiooh->nama[app()->getLocale()] ?? $lokasiooh->nama['id'] ?? '') : $lokasiooh->nama;
        $lokasiooh->deskripsi_lokasi = is_array($lokasiooh->deskripsi_lokasi) ? ($lokasiooh->deskripsi_lokasi[app()->getLocale()] ?? $lokasiooh->deskripsi_lokasi['id'] ?? '') : $lokasiooh->deskripsi_lokasi;

        return view('services.ooh-detail', compact('lokasiooh'));
    }

    public function showDoohDetail($id)
    {
        $lokasi = \App\Models\Lokasi::find($id);
        
        if (!$lokasi) {
            // Dummy fallback if ID doesn't exist in DB
            $lokasi = (object)[
                'id' => $id,
                'nama' => 'Jl. S. Parman (Cambridge Area)',
                'deskripsi_lokasi' => 'This is a premium dummy location shown because there are only ' . \App\Models\Lokasi::count() . ' records in the database.',
                'gambar' => null,
                'koordinat' => '3.5852,98.6652',
                'mobil' => '120,000',
                'motor' => '85,000',
                'media' => 'Videotron',
                'type' => 'Horizontal',
                'size' => '4m x 6m',
                'lighting' => 'LED',
            ];
            return view('services.dooh-detail', compact('lokasi'));
        }

        // Ensure translations are handled if needed, though view can also handle it
        $lokasi->nama = is_array($lokasi->nama) ? ($lokasi->nama[app()->getLocale()] ?? $lokasi->nama['id'] ?? '') : $lokasi->nama;
        $lokasi->deskripsi_lokasi = is_array($lokasi->deskripsi_lokasi) ? ($lokasi->deskripsi_lokasi[app()->getLocale()] ?? $lokasi->deskripsi_lokasi['id'] ?? '') : $lokasi->deskripsi_lokasi;

        return view('services.dooh-detail', compact('lokasi'));
    }

    public function showBrand(Request $request)
    {
        $brands = \App\Models\Brand::all();
        
        // Add dummy data if table is empty
        if ($brands->isEmpty()) {
            $brands = collect([
                (object)[
                    'id' => 1,
                    'tab_title' => 'Marathons',
                    'nama_brand' => 'Marathon Event',
                    'judul' => 'Participant Arrangement for Marathons',
                    'deskripsi' => '<p>Comprehensive crowd control, participant tagging, and event synchronization for large-scale outdoor events. We ensure your participants have a safe and well-organized experience.</p>',
                    'gambar' => 'dummy_marathon.jpg',
                    'detail' => [
                        [
                            'title' => 'Crowd Control',
                            'description' => 'Professional crowd management.',
                            'image_url' => 'dummy_crowd.jpg'
                        ],
                        [
                            'title' => 'Synchronization',
                            'description' => 'Perfect timing for all runners.',
                            'image_url' => 'dummy_sync.jpg'
                        ]
                    ]
                ],
                (object)[
                    'id' => 2,
                    'tab_title' => 'Exhibitions',
                    'nama_brand' => 'Tech Expo',
                    'judul' => 'Tech Exhibition Management',
                    'deskripsi' => '<p>End-to-end management for tech expos and brand showcases. Maximize your brand visibility with our strategic placement and engagement activities.</p>',
                    'gambar' => 'dummy_expo.jpg',
                    'detail' => []
                ]
            ]);
            
            // Temporary fix for asset URLs since these dummy images don't exist in storage
            foreach ($brands as $brand) {
                $brand->gambar = 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?q=80&w=600&auto=format&fit=crop';
                if (!empty($brand->detail)) {
                    foreach ($brand->detail as &$d) {
                        $d['image_url'] = 'https://images.unsplash.com/photo-1542204165-65bf26472b9b?q=80&w=400&auto=format&fit=crop';
                    }
                }
            }
        }
        
        $activeTab = (int) $request->query('tab', 0); // default 0 kalau nggak ada query
        
        return view('pages.service.brand-activity', compact('brands','activeTab'));
    }

    public function showPhotography()
    {
        $photography = \App\Models\Photography::all();
        return view('pages.PhotoVideo.photovideolist', compact('photography'));
    }

    public function legality()
    {
        $legalities = \App\Models\Legality::where('is_active', true)->orderBy('sort_order')->get();
        return view('pages.legality', compact('legalities'));
    }

    public function portofolio()
    {
        $categories = \App\Models\PortofolioCategory::latest()->get();
        return view('pages.portofolio.index', compact('categories'));
    }

    public function portofolioList(Request $request, $id)
    {
        $category = \App\Models\PortofolioCategory::findOrFail($id);
        
        $portfolios = \App\Models\Portofolio::where('kategori', $id)
            ->with('firstImage')
            ->latest('created_at')
            ->paginate(9);

        // All categories for filter dropdown (if needed elsewhere)
        $allCategories = \App\Models\PortofolioCategory::all();

        return view('pages.portofolio.list', compact('category', 'portfolios', 'allCategories'));
    }

    public function portofolioDetail($id)
    {
        $event = \App\Models\Portofolio::with(['images', 'category'])->findOrFail($id);
        $gallery = $event->images;
        $mainImage = $event->images->first();
        return view('pages.portofolio.detail', compact('event', 'gallery', 'mainImage'));
    }

    public function contact()
    {
        $faqs = \App\Models\Faq::where('is_active', true)->orderBy('sort_order')->get();
        return view('pages.contact', compact('faqs'));
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'subject' => 'nullable|string',
            'message' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'name.required' => 'Kolom nama wajib diisi.',
            'name.min' => 'Kolom nama minimal 3 inputan karakter.',
            'phone.required' => 'Kolom nomor telepon wajib diisi.',
            'phone.numeric' => 'Kolom nomor telepon wajib diisi dengan angka tanpa spasi atau karakter lain.',
            'email.required' => 'Kolom email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'message.required' => 'Kolom pesan wajib diisi.',
            'g-recaptcha-response.required' => 'Harap selesaikan reCAPTCHA.',
            'g-recaptcha-response.captcha' => 'reCAPTCHA tidak valid, harap coba lagi.',
        ]);

        $pesan = new Pesan();
        $pesan->nama = $request->name;
        $pesan->nomor_telepon = $request->phone;
        $pesan->email = $request->email;
        $pesan->subject = $request->subject;
        $pesan->pesan = $request->message;
        $pesan->save();

        return redirect()->route('contact')->with('success', 'Kamu berhasil mengirimkan pesan!');
    }
}