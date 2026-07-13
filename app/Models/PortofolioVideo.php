<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortofolioVideo extends Model
{
    use HasFactory;

    protected $table = 'portofolio_videos'; // pastikan ini sama dengan nama tabel kamu

    protected $fillable = [
        'portofolio_id',
        'video_path',
        'thumbnail'
    ];

    public function portofolio()
    {
        return $this->belongsTo(Portofolio::class);
    }
}