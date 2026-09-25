<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Portofolio extends Model
{
    use HasFactory;

    protected $table = 'portofolios';

    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'kategori', // Kolom ini menyimpan ID Kategori (Foreign Key)
        'tanggal',
        'klien',
        'lokasi',
        'gambar',
    ];

    // Relasi ke tabel Images
    public function images()
    {
        return $this->hasMany(PortofolioImage::class);
    }

    public function firstImage()
    {
        return $this->hasOne(PortofolioImage::class)->orderBy('id');
    }

    // Relasi ke tabel Category (Baru)
    public function category()
    {
        // Parameter 2 ('kategori') adalah nama kolom Foreign Key di tabel portofolios
        // Parameter 3 ('id') adalah nama kolom Primary Key di tabel portofolio_categories
        return $this->belongsTo(PortofolioCategory::class, 'kategori', 'id');
    }

    // Relasi ke tabel Videos (Baru ditambahkan)
    public function videos()
    {
        return $this->hasMany(PortofolioVideo::class);
    }

    protected static function booted()
    {
        static::saving(function ($portofolio) {
            // Judul portofolio disimpan dalam bentuk JSON ({"id": "...", "en": "..."})
            $judulData = $portofolio->judul;
            if (is_string($judulData)) {
                $decoded = json_decode($judulData, true);
                $judulString = is_array($decoded) ? ($decoded['id'] ?? reset($decoded)) : $judulData;
            } elseif (is_array($judulData)) {
                $judulString = $judulData['id'] ?? reset($judulData);
            } else {
                $judulString = '';
            }
            if (!empty($judulString)) {
                $baseSlug = Str::slug($judulString);
                $slug = $baseSlug;
                $count = 1;
                // Pastikan slug unik jika ada judul yang sama
                while (static::where('slug', $slug)->where('id', '!=', $portofolio->id ?? 0)->exists()) {
                    $slug = "{$baseSlug}-{$count}";
                    $count++;
                }
                $portofolio->slug = $slug;
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