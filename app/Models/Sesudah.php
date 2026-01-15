<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sesudah extends Model
{

    use HasFactory;
    protected $table = 'sesudah';
    protected $guarded = ['id'];
}
