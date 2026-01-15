<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sebelum extends Model
{
    use HasFactory;
    
    protected $table = 'sebelum';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'pengajuan_id',
        'kode_skpd',
        'kode_rekening',
        'jenis_ssh',
        'kode_komponen',
        'satuan',
        'harga',
        'koefisien1',
        'koefisien2',
        'koefisien3',
        'satuan1',
        'satuan2',
        'satuan3',
        'total',
    ];
    
    protected $casts = [
        'harga' => 'decimal:2',
        'koefisien1' => 'decimal:2',
        'koefisien2' => 'decimal:2',
        'koefisien3' => 'decimal:2',
        'total' => 'decimal:2',
    ];
    
    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class);
    }
}
