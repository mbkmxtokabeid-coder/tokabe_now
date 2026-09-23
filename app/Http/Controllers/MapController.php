<?php

namespace App\Http\Controllers;

use App\Models\LocationOoh;
use App\Models\LocationDooh;
use Illuminate\Http\Request;

class MapController extends Controller
{
    private function formatLocationName(mixed $nama, string $locale = 'id'): string
    {
        if (empty($nama)) return '';

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
                    // Provinces
                    'North Sumatra Province' => 'Provinsi Sumatera Utara',
                    'North Sumatera Province' => 'Provinsi Sumatera Utara',
                    'South Sumatra Province' => 'Provinsi Sumatera Selatan',
                    'West Sumatra Province' => 'Provinsi Sumatera Barat',
                    'Riau Province' => 'Provinsi Riau',
                    'Jambi Province' => 'Provinsi Jambi',
                    'Bengkulu Province' => 'Provinsi Bengkulu',
                    'Lampung Province' => 'Provinsi Lampung',

                    // Cities & Regencies
                    'Medan City' => 'Kota Medan',
                    'City of Medan' => 'Kota Medan',
                    'Binjai City' => 'Kota Binjai',
                    'Padang Sidempuan City' => 'Kota Padang Sidempuan',
                    'Deli Serdang Regency' => 'Kabupaten Deli Serdang',
                    'Simalungun Regency' => 'Kabupaten Simalungun',

                    // Specific Locations & Landmarks
                    'Captain Maulana Lubis Street' => 'Jl. Kapten Maulana Lubis',
                    'Juanda Street and Samanhudi Street' => 'Jl. Juanda dan Jl. Samanhudi',
                    'Juanda Street' => 'Jl. Juanda',
                    'Samanhudi Street' => 'Jl. Samanhudi',
                    'Setia Budi St.' => 'Jl. Setia Budi',
                    'KH. Zainul Arifin Street' => 'Jl. KH. Zainul Arifin',
                    'Zainul Arifin St.' => 'Jl. Zainul Arifin',
                    'Soekarno–Hatta Street' => 'Jl. Soekarno–Hatta',
                    'Soekarno-Hatta Street' => 'Jl. Soekarno-Hatta',
                    'Jendral Sudirman Street' => 'Jl. Jendral Sudirman',
                    'Jend. Sudirman Street' => 'Jl. Jend. Sudirman',
                    'Sudirman Street' => 'Jl. Sudirman',
                    'Imam Bonjol Street' => 'Jl. Imam Bonjol',
                    'Besar Delitua Street' => 'Jl. Besar Delitua',
                    'Flamboyan Raya Street' => 'Jl. Flamboyan Raya',
                    'Willem Iskandar Street' => 'Jl. Willem Iskandar',
                    'Karya Jaya Street' => 'Jl. Karya Jaya',
                    'Tengku Fachrudin Street' => 'Jl. Tengku Fachrudin',
                    'MT Haryono Street' => 'Jl. MT Haryono',
                    'MT. Haryono St.' => 'Jl. MT. Haryono',
                    'Asahan Street' => 'Jl. Asahan',
                    'Ahmad Yani Street' => 'Jl. Ahmad Yani',
                    'Sirao Street' => 'Jl. Sirao',
                    'Sonigeho Street' => 'Jl. Sonigeho',
                    'Lotu Street' => 'Jl. Lotu',
                    'R.A. Kartini Street' => 'Jl. R.A. Kartini',
                    'Sumatra Highway' => 'Jl. Lintas Sumatera',
                    'Lintas Sumatera Street' => 'Jl. Lintas Sumatera',
                    'Sumatera St.' => 'Jl. Sumatera',
                    'Yos Sudarso St.' => 'Jl. Yos Sudarso',
                    'Pertempuran St.' => 'Jl. Pertempuran',
                    'HM. Yamin St.' => 'Jl. HM. Yamin',
                    'Mabar St.' => 'Jl. Mabar',
                    'S. Parman St.' => 'Jl. S. Parman',
                    'Glugur St.' => 'Jl. Glugur',
                    'Gedung Arca St.' => 'Jl. Gedung Arca',
                    'HM Joni St.' => 'Jl. HM Joni',
                    'Ring Road St.' => 'Jl. Ring Road',
                    'Karya Wisata St.' => 'Jl. Karya Wisata',
                    'Flamboyan St.' => 'Jl. Flamboyan',
                    'Bilal St.' => 'Jl. Bilal',
                    'Jamin Ginting St.' => 'Jl. Jamin Ginting',
                    'Jamin Ginting Street' => 'Jl. Jamin Ginting',
                    'SM. Raja Street' => 'Jl. SM. Raja',
                    'S.M. Raja Street' => 'Jl. S.M. Raja',
                    'SM Raja Street' => 'Jl. SM Raja',

                    // Intersections & Descriptors
                    'right at the Juanda Monument intersection' => 'tepat di persimpangan Tugu Juanda',
                    'right at the intersection of' => 'tepat di persimpangan',
                    'right at the intersection' => 'tepat di persimpangan',
                    'at the intersection with' => 'di persimpangan dengan',
                    'Housing Complex Intersection' => 'Persimpangan Komplek Perumahan',
                    'Housing Complex' => 'Komplek Perumahan',
                    'Intersection' => 'Persimpangan',
                    'intersection' => 'persimpangan',
                    'Flyover Intersection' => 'Persimpangan Flyover',
                    'Former NAV Karaoke' => 'Eks NAV Karaoke',
                    'Former ' => 'Eks ',
                    'Former' => 'Eks',
                    'Ex. ' => 'Eks ',
                    'Ex ' => 'Eks ',
                    '(Ex ' => '(Eks ',
                    'Junction ' => 'Simp. ',
                    'Junction' => 'Simp.',
                    'In Front of' => 'di depan',
                    'In front of' => 'di depan',
                    'in front of' => 'di depan',
                    'Near' => 'dekat',
                    'near' => 'dekat',
                    'Toll Gate' => 'Gerbang Tol',
                    'Market Area' => 'Pasar',
                    'Market' => 'Pasar',
                    'District' => 'Kecamatan',
                    'Town' => 'Kota',
                    'Regency' => 'Kabupaten',
                    'Province' => 'Provinsi',
                    'Street' => 'Jl.',
                    ' St.' => ' Jl.',
                    ' St ' => ' Jl. ',
                    'Side A' => 'Sisi A',
                    'Side B' => 'Sisi B',
                    'Side 1' => 'Sisi 1',
                    'Side 2' => 'Sisi 2',
                    'Upper' => 'Atas',
                    'Lower' => 'Bawah',
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

        $cacheKey = 'sumatra_map_data_v3_' . $locale;

        $result = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function () use ($locale) {
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
                    'lokasi_ooh' => $oohItems->map(function ($item) use ($locale) {
                        return $this->formatLocationName($item->nama, $locale);
                    })->filter()->values()->toArray(),
                    'lokasi_videotron' => $doohItems->map(function ($item) use ($locale) {
                        return $this->formatLocationName($item->nama, $locale);
                    })->filter()->values()->toArray(),
                ];
            }

            return $data;
        });

        return response()->json($result);
    }
}
