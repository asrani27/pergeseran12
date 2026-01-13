<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skpd extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_skpd',
        'nama',
        'user_id',
        'kepala_id',
    ];

    protected $table = 'skpd';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kepala()
    {
        return $this->belongsTo(User::class, 'kepala_id');
    }
}
