<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        if (app()->environment('testing')) {

            Permission::updateOrCreate(['name' => 'Post:create', 'guard_name' => 'web']);
            Permission::updateOrCreate(['name' => 'Post:edit', 'guard_name' => 'web']);
            Permission::updateOrCreate(['name' => 'Post:delete', 'guard_name' => 'web']);

            $permission = Permission::all();

            foreach ($permission as $key => $item) {
                $roles = Role::where('name', $key)->get();
                foreach ($roles as $role) {
                    foreach ($item as $permission) {
                        $permission = Permission::where('name', $permission)->first();
                        $role->givePermissionTo($permission);
                    }
                }
            }
        } else {

            foreach ($this->permissions as $permission) {
                Permission::updateOrCreate(['name' => $permission]);
            }

            foreach ($this->rolePermissions as $key => $item) {
                $roles = Role::where('name', $key)->get();
                foreach ($roles as $role) {
                    foreach ($item as $permission) {
                        $permission = Permission::where('name', $permission)->first();
                        $role->givePermissionTo($permission);
                    }
                }
            }
        }
    }

    private $permissions = [
        'Post:view',
        'Post:create',
        'Post:edit',
        'Post:update',
        'Post:delete',
        'Comment:view',
        'Comment:create',
        'Comment:edit',
        'Comment:update',
        'Comment:delete',
    ];

    private $rolePermissions = [
        'Admin' => [
            'Post:delete',
            'Comment:delete',
        ],
        'Editor' => [
            'Post:view',
            'Post:create',
            'Post:edit',
            'Post:update',
            'Post:delete',
            'Comment:view',
            'Comment:create',
            'Comment:edit',
            'Comment:update',
        ],
        'User' => [
            'Comment:view',
            'Comment:create',
            'Comment:delete',
        ],
    ];

}
