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
        $result = \Illuminate\Support\Facades\Cache::remember('sumatra_map_data', 3600, function () {
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

            $data = [];
            foreach ($allProvinces as $provinsi) {
                $oohItems = $oohGrouped->get($provinsi, collect());
                $doohItems = $doohGrouped->get($provinsi, collect());

                $data[] = [
                    'provinsi' => $provinsi ?: 'Sumatera Utara',
                    'billboards' => $oohItems->count(),
                    'videotron' => $doohItems->count(),
                    'lokasi_ooh' => $oohItems->pluck('nama')->map(function ($nama) {
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

            return $data;
        });

        return response()->json($result);
    }
}
