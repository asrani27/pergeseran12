<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    /**
     * The table associated with model.
     *
     * @var string
     */
    protected $table = 'program';

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
        'kode_skpd',
        'skpd_id',
        'kode',
        'nama',
        'tahun',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'skpd_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the skpd that owns the program.
     */
    public function skpd()
    {
        return $this->belongsTo(Skpd::class, 'skpd_id', 'id');
    }

    /**
     * Get the kegiatans for the program.
     */
    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class, 'program_id', 'id');
    }

    /**
     * Get the subkegiatans for the program through kegiatans.
     */
    public function subkegiatans()
    {
        return $this->hasManyThrough(
            Subkegiatan::class,
            Kegiatan::class,
            'program_id', // Foreign key on kegiatans table
            'kegiatan_id', // Foreign key on subkegiatans table
            'id', // Local key on programs table
            'id' // Local key on kegiatans table
        );
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
     * Get the full name with kode.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->kode} - {$this->nama}";
    }
}
