<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lokasioohs', function (Blueprint $table) {
            $table->string('motor')->nullable()->change();
            $table->string('mobil')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lokasioohs', function (Blueprint $table) {
            $table->string('motor')->nullable(false)->change();
            $table->string('mobil')->nullable(false)->change();
        });
    }
};
