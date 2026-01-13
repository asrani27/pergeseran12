<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatImport extends Model
{
    protected $fillable = [
        'nama_file',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
