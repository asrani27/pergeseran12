<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subkegiatan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subkegiatan';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'skpd_id',
        'program_id',
        'kegiatan_id',
        'kode',
        'nama',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'skpd_id' => 'integer',
        'program_id' => 'integer',
        'kegiatan_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the skpd that owns the subkegiatan.
     */
    public function skpd()
    {
        return $this->belongsTo(Skpd::class, 'skpd_id', 'id');
    }

    /**
     * Get the program that owns the subkegiatan.
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    /**
     * Get the kegiatan that owns the subkegiatan.
     */
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id', 'id');
    }

    /**
     * Scope a query to filter by skpd.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $skpdId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBySkpd($query, $skpdId)
    {
        return $query->where('skpd_id', $skpdId);
    }

    /**
     * Scope a query to filter by program.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $programId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByProgram($query, $programId)
    {
        return $query->where('program_id', $programId);
    }

    /**
     * Scope a query to filter by kegiatan.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $kegiatanId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByKegiatan($query, $kegiatanId)
    {
        return $query->where('kegiatan_id', $kegiatanId);
    }

    /**
     * Get the full name with kode.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->kode} - {$this->nama}";
    }

    /**
     * Get the full hierarchical name.
     *
     * @return string
     */
    public function getFullHierarchyNameAttribute()
    {
        return "{$this->kode} - {$this->nama} ({$this->kegiatan->kode} - {$this->kegiatan->nama})";
    }
}
