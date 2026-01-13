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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skpd_id')->constrained('skpds')->onDelete('cascade');
            $table->string('kode');
            $table->string('nama');
            $table->timestamps();
            
            $table->index('skpd_id');
            $table->unique(['skpd_id', 'kode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
