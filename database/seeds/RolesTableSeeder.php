<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Has all permissions'
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Has add/edit permissions, delete requires approval'
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'description' => 'Regular user with basic access'
            ]
        ];
        
        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
