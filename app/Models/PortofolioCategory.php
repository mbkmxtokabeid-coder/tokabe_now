<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortofolioCategory extends Model
{
    use HasFactory;

    // Opsional: Definisikan nama tabel jika tidak mengikuti konvensi Laravel (jamak)
    // protected $table = 'portofolio_categories';

    protected $fillable = [
        'nama_kategori',
        'image',
    ];

    /**
     * Relasi One-to-Many ke model Portofolio.
     * * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function portofolios()
    {
        // Parameter 2: 'kategori' adalah foreign key di tabel portofolios
        // Parameter 3: 'id' adalah primary key di tabel portofolio_categories
        return $this->hasMany(Portofolio::class, 'kategori', 'id');
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