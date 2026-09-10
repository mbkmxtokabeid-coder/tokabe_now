<?php

namespace App\Http\Controllers;

use App\Models\LocationOoh;
use App\Models\LocationDooh;
use Illuminate\Http\Request;

class MapController extends Controller
{
    private function formatLocationName(mixed $nama): string
    {
        if (empty($nama)) return '';
        $locale = app()->getLocale();

        if (is_string($nama)) {
            $trimmed = trim($nama);
            if (str_starts_with($trimmed, '{') && str_ends_with($trimmed, '}')) {
                $decoded = json_decode($trimmed, true);
                if (is_array($decoded)) {
                    $nama = $decoded;
                }
            }
        }

        if (is_array($nama)) {
            if ($locale === 'en') {
                $str = ($nama['en'] ?? '')
                    ?: ($nama['id'] ?? '')
                    ?: (collect($nama)->first() ?? '');
            } else {
                $str = ($nama['id'] ?? '')
                    ?: ($nama['en'] ?? '')
                    ?: (collect($nama)->first() ?? '');
            }
        } else {
            $str = (string)$nama;
        }

        if (!empty($str)) {
            if ($locale === 'en') {
                $replacements = [
                    'Provinsi Sumatera Utara' => 'North Sumatra Province',
                    'Provinsi Sumatera Selatan' => 'South Sumatra Province',
                    'Provinsi Sumatera Barat' => 'West Sumatra Province',
                    'Provinsi Riau' => 'Riau Province',
                    'Provinsi Jambi' => 'Jambi Province',
                    'Provinsi Bengkulu' => 'Bengkulu Province',
                    'Provinsi Lampung' => 'Lampung Province',
                    'Kota Medan' => 'Medan City',
                    'Provinsi ' => 'Province ',
                    'Kota ' => 'City of ',
                    'tepat di persimpangan' => 'right at the intersection of',
                    ' (Eks ' => ' (Ex ',
                    ' Eks ' => ' Ex ',
                    'Eks. ' => 'Ex ',
                    'Eks ' => 'Ex ',
                    'Simp. ' => 'Junction ',
                    'Simpang ' => 'Junction ',
                    ' persimpangan ' => ' intersection ',
                    ' Persimpangan ' => ' Intersection ',
                    ' dan ' => ' and ',
                ];
            } else {
                $replacements = [
                    'North Sumatra Province' => 'Provinsi Sumatera Utara',
                    'North Sumatera Province' => 'Provinsi Sumatera Utara',
                    'South Sumatra Province' => 'Provinsi Sumatera Selatan',
                    'West Sumatra Province' => 'Provinsi Sumatera Barat',
                    'Riau Province' => 'Provinsi Riau',
                    'Jambi Province' => 'Provinsi Jambi',
                    'Bengkulu Province' => 'Provinsi Bengkulu',
                    'Lampung Province' => 'Provinsi Lampung',
                    'Medan City' => 'Kota Medan',
                    'City of Medan' => 'Kota Medan',
                    'right at the Juanda Monument intersection' => 'tepat di persimpangan Tugu Juanda',
                    'right at the intersection of' => 'tepat di persimpangan',
                    'Housing Complex Intersection' => 'Persimpangan Komplek Perumahan',
                    'Housing Complex' => 'Komplek Perumahan',
                    'Former NAV Karaoke' => 'Eks NAV Karaoke',
                    'Former ' => 'Eks ',
                    ' (Ex ' => ' (Eks ',
                    ' Ex ' => ' Eks ',
                    'Ex. ' => 'Eks ',
                    'Junction ' => 'Simp. ',
                    'Intersection with' => 'Simp. ',
                    'intersection' => 'persimpangan',
                    'Intersection' => 'Persimpangan',
                    ' Captain Maulana Lubis Street, ' => ' Jl. Kapten Maulana Lubis, ',
                    'Captain Maulana Lubis Street' => 'Jl. Kapten Maulana Lubis',
                    'Juanda Street and Samanhudi Street' => 'Jl. Juanda dan Jl. Samanhudi',
                    'Juanda Street' => 'Jl. Juanda',
                    'Samanhudi Street' => 'Jl. Samanhudi',
                    'Setia Budi St.' => 'Jl. Setia Budi',
                    'KH. Zainul Arifin Street' => 'Jl. KH. Zainul Arifin',
                    ' Street, ' => 'Jl. ',
                    ' Street' => 'Jl. ',
                    ' St. ' => 'Jl. ',
                    ' St.' => 'Jl.',
                    ' near ' => ' dekat ',
                    ' Near ' => ' Dekat ',
                ];
            }
            $str = strtr($str, $replacements);
        }

        return $str;
    }

    /**
     * Return map data for the Sumatra map component.
     * Returns billboard (OOH) and videotron (DOOH) counts per province,
     * plus location names for each category.
     */
    public function getMapData(Request $request)
    {
        $locale = $request->get('lang')
            ?: session('locale')
            ?: $request->cookie('locale')
            ?: app()->getLocale();

        if (in_array($locale, ['en', 'id'])) {
            app()->setLocale($locale);
        } else {
            $locale = 'id';
            app()->setLocale('id');
        }

        $cacheKey = 'sumatra_map_data_' . $locale;

        $result = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function () {
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
                    'lokasi_ooh' => $oohItems->map(function ($item) {
                        return $this->formatLocationName($item->nama);
                    })->filter()->values()->toArray(),
                    'lokasi_videotron' => $doohItems->map(function ($item) {
                        return $this->formatLocationName($item->nama);
                    })->filter()->values()->toArray(),
                ];
            }

            return $data;
        });

        return response()->json($result);
    }
}
