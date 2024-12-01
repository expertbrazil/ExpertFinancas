<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'permissions'
    ];

    protected $casts = [
        'permissions' => 'array'
    ];

    /**
     * Get the users for the role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if the role has a specific permission
     */
    public function hasPermission($permission)
    {
        if ($this->isAdmin()) {
            return true;
        }

        return in_array($permission, $this->permissions ?? []);
    }

    /**
     * Check if the role has any of the given permissions
     */
    public function hasAnyPermission(array $permissions)
    {
        if ($this->isAdmin()) {
            return true;
        }

        return !empty(array_intersect($permissions, $this->permissions ?? []));
    }

    /**
     * Check if the role has all of the given permissions
     */
    public function hasAllPermissions(array $permissions)
    {
        if ($this->isAdmin()) {
            return true;
        }

        return empty(array_diff($permissions, $this->permissions ?? []));
    }

    public function isAdmin()
    {
        return $this->slug === 'admin';
    }

    public function isUser()
    {
        return $this->slug === 'user';
    }
}
