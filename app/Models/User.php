<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'cliente_id'
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

    /**
     * Get the client that owns the user.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Check if user has a specific permission through their role
     */
    public function hasPermission($permission)
    {
        return $this->role ? $this->role->hasPermission($permission) : false;
    }

    /**
     * Check if user has any of the given permissions through their role
     */
    public function hasAnyPermission(array $permissions)
    {
        return $this->role ? $this->role->hasAnyPermission($permissions) : false;
    }

    /**
     * Check if user has all of the given permissions through their role
     */
    public function hasAllPermissions(array $permissions)
    {
        return $this->role ? $this->role->hasAllPermissions($permissions) : false;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role ? $this->role->isAdmin() : false;
    }

    /**
     * The "booting" method of the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Impedir a exclusão do usuário root
        static::deleting(function ($user) {
            if ($user->email === 'root@expertfinancas.com.br') {
                throw new \Exception('O usuário root do sistema não pode ser excluído.');
            }
        });

        // Impedir a desativação do usuário root
        static::updating(function ($user) {
            if ($user->email === 'root@expertfinancas.com.br' && !$user->ativo) {
                throw new \Exception('O usuário root do sistema não pode ser desativado.');
            }
        });
    }

    /**
     * Get the role that owns the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if user is user
     */
    public function isUser()
    {
        return $this->role && $this->role->isUser();
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($roleName)
    {
        return $this->role->name === $roleName;
    }

    /**
     * Get the user's profile photo URL.
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo && file_exists(public_path($this->profile_photo))) {
            return asset($this->profile_photo);
        }
        return asset('images/default-avatar.png');
    }
}
