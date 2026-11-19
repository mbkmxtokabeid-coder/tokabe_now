<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationDooh extends Model
{
    use HasFactory;

    // Tabel di migration bernama 'lokasis', bukan 'location_doohs' (default Laravel)
    protected $table = 'lokasis';

    protected $guarded = ['id'];

    // Remove casts because it breaks old string data
    // protected $casts = [
    //     'nama' => 'array',
    //     'deskripsi_lokasi' => 'array',
    // ];

    public function getNamaAttribute($value)
    {
        if (empty($value)) return null;
        $decoded = json_decode($value, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
    }

    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getDeskripsiLokasiAttribute($value)
    {
        if (empty($value)) return null;
        $decoded = json_decode($value, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
    }

    public function setDeskripsiLokasiAttribute($value)
    {
        $this->attributes['deskripsi_lokasi'] = is_array($value) ? json_encode($value) : $value;
    }

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('homepage_data');
            \Illuminate\Support\Facades\Cache::forget('sumatra_map_data_v3_id');
            \Illuminate\Support\Facades\Cache::forget('sumatra_map_data_v3_en');
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('homepage_data');
            \Illuminate\Support\Facades\Cache::forget('sumatra_map_data_v3_id');
            \Illuminate\Support\Facades\Cache::forget('sumatra_map_data_v3_en');
        });
    }
}
