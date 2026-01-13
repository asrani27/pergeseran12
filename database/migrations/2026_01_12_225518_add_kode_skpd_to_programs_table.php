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
            $table->string('kode_skpd')->nullable()->after('id');
            
            // Add index for performance
            $table->index('kode_skpd');
            
            // Add unique constraint for kode_skpd and kode combination
            $table->unique(['kode_skpd', 'kode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropUnique(['kode_skpd', 'kode']);
            $table->dropIndex(['kode_skpd']);
            $table->dropColumn('kode_skpd');
        });
    }
};
