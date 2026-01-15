<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Skpd;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the SKPD where this user is the user (operator/admin)
     */
    public function skpdAsUser()
    {
        return $this->hasOne(Skpd::class, 'user_id');
    }

    /**
     * Get the SKPD where this user is the kepala (head)
     */
    public function skpdAsKepala()
    {
        return $this->hasOne(Skpd::class, 'kepala_id');
    }

    /**
     * Get the SKPD for the user (either as user or kepala)
     */
    public function getSkpdAttribute()
    {
        return $this->skpdAsUser ?? $this->skpdAsKepala ?? null;
    }
}
