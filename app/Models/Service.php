<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'judul','endpoint', 'deskripsi', 'ikon', 'sort_order', 'status', 'gambar'
    ];

    protected $casts = [
        'judul' => 'array',
        'deskripsi' => 'array',
    ];

    protected static function booted()
    {
        static::saving(function ($service) {
            // Auto-generate slug ke kolom endpoint dari judul['id']
            if (empty($service->endpoint)) {
                $judulData = $service->judul;

                if (is_array($judulData)) {
                    $judulString = $judulData['id'] ?? reset($judulData);
                } elseif (is_string($judulData)) {
                    $decoded = json_decode($judulData, true);
                    $judulString = is_array($decoded) ? ($decoded['id'] ?? reset($decoded)) : $judulData;
                } else {
                    $judulString = '';
                }

                if (!empty($judulString)) {
                    $baseSlug = Str::slug($judulString);
                    $slug = $baseSlug;
                    $count = 1;
                    while (static::where('endpoint', $slug)
                        ->where('id', '!=', $service->id ?? 0)
                        ->exists()) {
                        $slug = "{$baseSlug}-{$count}";
                        $count++;
                    }
                    $service->endpoint = $slug;
                }
            }
        });

        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('homepage_data');
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('homepage_data');
        });
    }

    public function serviceCategories()
    {
        return $this->hasMany(ServiceCategory::class);
    }
}