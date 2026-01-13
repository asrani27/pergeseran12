<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = "pengajuan";
    protected $fillable = [
        'user_id',
        'skpd_id',
        'tanggal',
        'nomor_surat',
        'tipe_pengajuan',
        'hal',
        'pengantar',
        'lampiran',
        'program_id',
        'kegiatan_id',
        'subkegiatan_id',
        'status_operator',
        'status_kepala_skpd',
        'status_bpkpad',
        'ket_kepala_skpd',
        'ket_bpkpad',
        'kode_program',
        'nama_program',
        'kode_kegiatan',
        'nama_kegiatan',
        'kode_subkegiatan',
        'nama_subkegiatan',
        'tahun',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'status_operator' => 'integer',
        'status_kepala_skpd' => 'integer',
        'status_bpkpad' => 'integer',
        'tahun' => 'integer',
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with SKPD
     */
    public function skpd()
    {
        return $this->belongsTo(Skpd::class);
    }

    /**
     * Relationship with Program
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Relationship with Kegiatan
     */
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    /**
     * Relationship with Subkegiatan
     */
    public function subkegiatan()
    {
        return $this->belongsTo(Subkegiatan::class);
    }
}
