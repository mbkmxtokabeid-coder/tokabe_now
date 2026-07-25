<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'title',
        'description',
        'dooh_description',
        'ooh_description',
        'image_dooh',
        'dooh_target',
        'image_ooh',
        'ooh_target',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'dooh_description' => 'array',
        'ooh_description' => 'array',
    ];

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
