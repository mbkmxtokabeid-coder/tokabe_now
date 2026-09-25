<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 
class Lokasi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    private function decodeField(string $field): mixed
    {
        $raw = $this->attributes[$field] ?? $this->getRawOriginal($field);
        if ($raw === null || $raw === '') return null;
        if (is_array($raw)) return $raw;
        $decoded = json_decode($raw, true);
        return (json_last_error() === JSON_ERROR_NONE) ? $decoded : $raw;
    }

    public function getNamaAttribute(): mixed            { return $this->decodeField('nama'); }
    public function getDeskripsiLokasiAttribute(): mixed { return $this->decodeField('deskripsi_lokasi'); }
    public function getTaglineAttribute(): mixed         { return $this->decodeField('tagline'); }

    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = is_array($value) ? json_encode($value) : $value;
    }

    public function setDeskripsiLokasiAttribute($value)
    {
        $this->attributes['deskripsi_lokasi'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getFormattedGambarAttribute()
    {
        if (str_contains($this->gambar, 'image_lokasi/')) {
            return $this->gambar;
        }
        return 'image_lokasi/' . $this->gambar;
    }

    protected static function booted()
    {
        static::saving(function ($lokasi) {
            $namaString = is_array($lokasi->nama) 
                ? ($lokasi->nama['id'] ?? reset($lokasi->nama)) 
                : $lokasi->nama;
            
            $namaString = str_replace('.', ' ', $namaString);
            if (!empty($namaString)) {
                $stopwords = [
                    'kota', 'wilayah', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan',
                    'dan', 'di', 'ke', 'dari', 'tepat', 'pada', 'persimpangan', 'simpang',
                    'banda','aceh','medan','jambi','depan','pangkal','pinang','gedung','pangkalan',
                    'depan', 'seberang', 'dekat', 'gedung','dengan','simp','simpang',
                    'sumatera utara', 'sumatera barat', 'sumatera selatan', 'sumut', 'sumbar', 'sumsel',
                    'labuhan batu selatan', 'labuhan batu utara', 'padang lawas utara',
                    'pematang siantar', 'serdang bedagai', 'tapanuli selatan', 'tapanuli tengah',
                    'tapanuli utara', 'mandailing natal', 'padang sidempuan', 'bandar lampung',
                    'bangka selatan', 'bangka tengah', 'belitung timur', 'deli serdang',
                    'gunung sitoli', 'pangkal pinang', 'rantau prapat', 'tanjung balai',
                    'tebing tinggi', 'bangka barat', 'padang lawas', 'labuhan batu',
                    'nias selatan', 'nias barat', 'nias utara', 'pulau nias', 'banda aceh',
                    'sawahlunto', 'simalungun', 'berastagi', 'pekanbaru', 'palembang',
                    'bengkulu', 'batubara', 'samosir', 'sibolga', 'sidikalang', 'sijunjung',
                    'asahan', 'belitung', 'bangka', 'binjai', 'langkat', 'balige',
                    'medan', 'padang', 'jambi', 'batam', 'solok', 'agam', 'aceh', 'setelah','sebelah','halaman','parkir'
                ];
                
                $pattern = '/\b(' . implode('|', $stopwords) . ')\b/iu';
                $cleanString = preg_replace($pattern, '', $namaString);
                $cleanString = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $cleanString);
                $cleanString = trim(preg_replace('/\s+/', ' ', $cleanString));
                
                $words = preg_split('/\s+/', $cleanString, -1, PREG_SPLIT_NO_EMPTY);
                $take = 5;
                $selectedWords = array_slice($words, 0, $take);
                while (!empty($selectedWords) && strlen(end($selectedWords)) <= 2 && isset($words[$take])) {
                    $selectedWords[] = $words[$take];
                    $take++;
                }
                $baseSlug = Str::slug(implode(' ', $selectedWords));
                $baseSlug = preg_replace('/(-jl|-jalan)+$/i', '', $baseSlug);
                $baseSlug = rtrim($baseSlug, '-');
                $slug = $baseSlug;
                $count = 1;
                while (static::where('slug', $slug)->where('id', '!=', $lokasi->id ?? 0)->exists()) {
                    $slug = "{$baseSlug}-{$count}";
                    $count++;
                }
                $lokasi->slug = $slug;
            }
        });

        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('homepage_data');
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('homepage_data');
        });
    }
}

