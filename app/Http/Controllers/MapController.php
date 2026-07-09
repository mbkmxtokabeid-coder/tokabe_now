<?php

namespace App\Http\Controllers;

use App\Models\LocationOoh;
use App\Models\LocationDooh;
use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Return map data for the Sumatra map component.
     * Returns billboard (OOH) and videotron (DOOH) counts per province,
     * plus location names for each category.
     */
    public function getMapData()
    {
        // Ambil semua data OOH dan DOOH dari database
        $oohLocations = LocationOoh::all();
        $doohLocations = LocationDooh::all();

        $normalizeProv = function($prov) {
            if (empty($prov)) return 'Sumatera Utara';
            return str_replace('Sumatra', 'Sumatera', $prov);
        };

        // Group by wilayah/region (provinsi)
        $oohGrouped = $oohLocations->groupBy(function($item) use ($normalizeProv) {
            return $normalizeProv($item->provinsi);
        });
        $doohGrouped = $doohLocations->groupBy(function ($item) use ($normalizeProv) {
            return $normalizeProv($item->provinsi);
        });

        // Kumpulkan semua unique provinces
        $allProvinces = $oohGrouped->keys()->merge($doohGrouped->keys())->unique();

        $result = [];
        foreach ($allProvinces as $provinsi) {
            $oohItems = $oohGrouped->get($provinsi, collect());
            $doohItems = $doohGrouped->get($provinsi, collect());

            $result[] = [
                'provinsi' => $provinsi ?: 'Sumatera Utara',
                'billboards' => $oohItems->count(),
                'videotron' => $doohItems->count(),
                'lokasi_ooh' => $oohItems->pluck('nama')->map(function ($nama) {
                    // Jika nama berupa JSON/array (multi-bahasa), ambil versi Indonesia
                    if (is_array($nama)) {
                        return $nama['id'] ?? $nama['en'] ?? json_encode($nama);
                    }
                    return $nama;
                })->values()->toArray(),
                'lokasi_videotron' => $doohItems->pluck('nama')->map(function ($nama) {
                    if (is_array($nama)) {
                        return $nama['id'] ?? $nama['en'] ?? json_encode($nama);
                    }
                    return $nama;
                })->values()->toArray(),
            ];
        }

        return response()->json($result);
    }
}
