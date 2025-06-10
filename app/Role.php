<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'slug', 'description'];
    
    // public function permissions()
    // {
    //     return $this->belongsToMany(Permission::class, 'role_has_permissions');
    // }
    
    // public function users()
    // {
    //     return $this->hasMany(User::class);
    // }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }
}
