<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'score',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_confirmed_at' => 'datetime',
    ];

    /**
     * Check if two-factor authentication has been enabled.
     *
     * @return bool
     */
    public function hasTwoFactorEnabled()
    {
        return !is_null($this->two_factor_secret) && !is_null($this->two_factor_confirmed_at);
    }


    public function solutions()
    {
        return $this->hasMany(Solution::class);
    }
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
    public function completedChallenges()
    {
        return $this->belongsToMany(Challenge::class)->withTimestamps();
    }
    public function subscription()
    {
        return $this->hasOne(Subscription::class); // Adjust based on your actual relationship
    }

}
