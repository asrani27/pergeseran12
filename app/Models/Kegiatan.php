<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kegiatan';

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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the skpd that owns the kegiatan.
     */
    public function skpd()
    {
        return $this->belongsTo(Skpd::class, 'skpd_id', 'id');
    }

    /**
     * Get the program that owns the kegiatan.
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    /**
     * Get the subkegiatans for the kegiatan.
     */
    public function subkegiatans()
    {
        return $this->hasMany(Subkegiatan::class, 'kegiatan_id', 'id');
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
     * Get the full name with kode.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->kode} - {$this->nama}";
    }
}
