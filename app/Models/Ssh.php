<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ssh extends Model
{
    use HasFactory;
    protected $table = 'ssh';
    protected $guarded = ['id'];
    public $timestamps = false;
}
