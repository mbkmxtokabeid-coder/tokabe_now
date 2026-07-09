<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LocationOoh;
use App\Models\Lokasi;
use Illuminate\Support\Str;

class DiscoverController extends Controller
{
    public function index(Request $request)
    {
        $region = $request->query('region');
        $search = $request->query('s');
        $type = $request->query('type');
        $page = $request->query('page', 1);
        $perPage = 9;

        // Query untuk OOH
        $queryOoh = LocationOoh::query();
        if ($region) {
            $queryOoh->where('provinsi', 'LIKE', "%{$region}%");
        }
        if ($search) {
            $queryOoh->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('provinsi', 'LIKE', "%{$search}%")
                  ->orWhere('wilayah', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi_lokasi', 'LIKE', "%{$search}%");
            });
        }

        // Query untuk DOOH
        $queryDooh = Lokasi::query();
        if ($region) {
            $queryDooh->where('provinsi', 'LIKE', "%{$region}%");
        }
        if ($search) {
            $queryDooh->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('provinsi', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi_lokasi', 'LIKE', "%{$search}%");
            });
        }

        $notificationMessage = null;
        
        if ($type === 'DOOH') {
            $totalDooh = $queryDooh->count();
            $lokasiDooh = $queryDooh->skip(($page - 1) * $perPage)->take($perPage)->get();
            $lokasiOoh = collect([]);
            
            $totalPagesDooh = ceil($totalDooh / $perPage);
            $totalPagesOoh = 0;
            
            if ($lokasiDooh->isEmpty() && ($region || $search)) {
                $notificationMessage = 'DOOH is not available in this regional';
            }
        } elseif ($type === 'OOH') {
            $totalOoh = $queryOoh->count();
            $lokasiOoh = $queryOoh->skip(($page - 1) * $perPage)->take($perPage)->get();
            $lokasiDooh = collect([]);
            
            $totalPagesOoh = ceil($totalOoh / $perPage);
            $totalPagesDooh = 0;
            
            if ($lokasiOoh->isEmpty() && ($region || $search)) {
                $notificationMessage = 'OOH is not available in this regional';
            }
        } else {
            $totalDooh = $queryDooh->count();
            $totalOoh = $queryOoh->count();
            
            $lokasiDooh = $queryDooh->skip(($page - 1) * $perPage)->take($perPage)->get();
            $lokasiOoh = $queryOoh->skip(($page - 1) * $perPage)->take($perPage)->get();
            
            $totalPagesDooh = ceil($totalDooh / $perPage);
            $totalPagesOoh = ceil($totalOoh / $perPage);
        }

        // Fetch all unique provinces for the filter dropdown
        $provincesOoh = LocationOoh::pluck('provinsi')->unique()->toArray();
        $provincesDooh = Lokasi::pluck('provinsi')->unique()->toArray();
        
        $allProvinces = collect(array_merge($provincesOoh, $provincesDooh))
            ->filter() // Remove null/empty
            ->map(function($prov) { 
                return str_replace('Sumatra', 'Sumatera', $prov); 
            })
            ->unique()
            ->sort()
            ->values();

        return view('discover', compact(
            'region', 
            'lokasiOoh', 
            'lokasiDooh', 
            'search', 
            'type', 
            'notificationMessage',
            'page',
            'totalPagesDooh',
            'totalPagesOoh',
            'allProvinces'
        ));
    }
}
