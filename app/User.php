<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

      public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    // public function hasPermission($slug)
    // {
    //     return $this->role->permissions()->where('slug', $slug)->exists();
    // }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }


     public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_has_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_has_permissions');
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('slug', $role);
        }

        return !! $role->intersect($this->roles)->count();
    }

    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            return $this->permissions->contains('slug', $permission) || 
                   $this->roles->contains(function($role) use ($permission) {
                       return $role->permissions->contains('slug', $permission);
                   });
        }

        return $this->permissions->contains($permission) || 
               $this->roles->contains(function($role) use ($permission) {
                   return $role->permissions->contains($permission);
               });
    }
}
