<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasiooh extends Model
{
    use HasFactory;

    protected $table = 'lokasioohs';

    protected $guarded = ['id'];

    public function getNamaAttribute($value)
    {
        if (empty($value)) return null;
        if (is_array($value)) return $value;
        $decoded = json_decode($value, true);
        return (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : $value;
    }

    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value;
    }

    public function getDeskripsiLokasiAttribute($value)
    {
        if (empty($value)) return null;
        if (is_array($value)) return $value;
        $decoded = json_decode($value, true);
        return (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : $value;
    }

    public function setDeskripsiLokasiAttribute($value)
    {
        $this->attributes['deskripsi_lokasi'] = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value;
    }

    public function getTaglineAttribute($value)
    {
        if (empty($value)) return null;
        if (is_array($value)) return $value;
        $decoded = json_decode($value, true);
        return (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : $value;
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