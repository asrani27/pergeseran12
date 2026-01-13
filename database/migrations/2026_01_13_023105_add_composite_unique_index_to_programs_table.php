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
        Schema::table('programs', function (Blueprint $table) {
            // Drop existing unique constraint that might conflict
            $table->dropUnique('programs_kode_skpd_kode_unique');
            
            // Add composite unique index on tahun, kode_skpd, and kode
            $table->unique(['tahun', 'kode_skpd', 'kode'], 'programs_tahun_kode_skpd_kode_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            // Drop the composite unique index
            $table->dropUnique('programs_tahun_kode_skpd_kode_unique');
            
            // Restore the original unique constraint
            $table->unique(['kode_skpd', 'kode'], 'programs_kode_skpd_kode_unique');
        });
    }
};
