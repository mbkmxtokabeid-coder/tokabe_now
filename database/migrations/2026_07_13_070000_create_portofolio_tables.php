<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('portofolio_categories')) {
            Schema::create('portofolio_categories', function (Blueprint $table) {
                $table->id();
                $table->string('nama_kategori')->nullable();
                $table->string('image')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('portofolios')) {
            Schema::create('portofolios', function (Blueprint $table) {
                $table->id();
                $table->text('judul')->nullable();
                $table->text('deskripsi')->nullable();
                $table->unsignedBigInteger('kategori')->nullable();
                $table->string('klien')->nullable();
                $table->date('tanggal')->nullable();
                $table->string('lokasi')->nullable();
                $table->string('gambar')->nullable();
                $table->timestamps();

                $table->foreign('kategori')->references('id')->on('portofolio_categories')->onDelete('set null');
            });
        }

        if (!Schema::hasTable('portofolio_images')) {
            Schema::create('portofolio_images', function (Blueprint $table) {
                $table->id();
                $table->foreignId('portofolio_id')->constrained('portofolios')->onDelete('cascade');
                $table->string('image');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('portofolio_videos')) {
            Schema::create('portofolio_videos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('portofolio_id')->constrained('portofolios')->onDelete('cascade');
                $table->string('video_path')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portofolio_videos');
        Schema::dropIfExists('portofolio_images');
        Schema::dropIfExists('portofolios');
        Schema::dropIfExists('portofolio_categories');
    }
};
