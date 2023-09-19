<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// The User model requires this trait
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Database\Eloquent\Builder;
class User extends Authenticatable
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable;



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function getStoredRole()
    {
        $roleClass = SpatieRole::class;

        $role = $this->roles()->first();

        if (is_string($role)) {
            return $roleClass::findByName($role, $this->getDefaultGuardName());
        }

        return $role;
    }
    public function scopeRole(Builder $query, string $role)
{
    return $query->whereHas('role', function ($query) use ($role) {
        $query->where('name', $role);
    });
}
}
