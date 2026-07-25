<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    private function decodeField(string $field): mixed
    {
        $raw = $this->getRawOriginal($field);
        if ($raw === null || $raw === '') return null;
        if (is_array($raw)) return $raw;
        $decoded = json_decode($raw, true);
        return (json_last_error() === JSON_ERROR_NONE) ? $decoded : $raw;
    }

    public function getNamaAttribute(): mixed            { return $this->decodeField('nama'); }
    public function getDeskripsiLokasiAttribute(): mixed { return $this->decodeField('deskripsi_lokasi'); }
    public function getTaglineAttribute(): mixed         { return $this->decodeField('tagline'); }

    public function getFormattedGambarAttribute()
    {
        if (str_contains($this->gambar, 'image_lokasi/')) {
            return $this->gambar;
        }
        return 'image_lokasi/' . $this->gambar;
    }

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('homepage_data');
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('homepage_data');
        });
    }
}

