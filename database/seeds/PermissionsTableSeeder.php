<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   public function run()
    {
        $permissions = [
            [
                'name' => 'Add',
                'slug' => 'add',
                'description' => 'Permission to add content'
            ],
            [
                'name' => 'Edit',
                'slug' => 'edit',
                'description' => 'Permission to edit content'
            ],
            [
                'name' => 'Delete',
                'slug' => 'delete',
                'description' => 'Permission to delete content'
            ],
            [
                'name' => 'Approve Delete',
                'slug' => 'approve-delete',
                'description' => 'Permission to approve delete requests'
            ]
        ];
        
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
        
        // Assign permissions to roles
        $superAdmin = Role::where('slug', 'super-admin')->first();
        $superAdmin->permissions()->attach(Permission::all());
        
        $admin = Role::where('slug', 'admin')->first();
        $admin->permissions()->attach(Permission::whereIn('slug', ['add', 'edit'])->get());
        
        $user = Role::where('slug', 'user')->first();
        // Users might not have direct permissions, handled via role
    }
}
