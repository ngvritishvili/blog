<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->environment('testing')) {
            Role::create(['name' => 'Admin', 'guard_name' => 'web']);
            Role::create(['name' => 'Editor', 'guard_name' => 'web']);
            Role::create(['name' => 'User', 'guard_name' => 'web']);
        } else {

            $data = [];

            foreach ($this->data as $role) {
                $data[] = ['name' => $role, 'guard_name' => 'web'];
            }

            Role::upsert($data, ['name'], ['name']);
        }

    }

    protected $data = [
        'Admin',
        'Editor',
        'User',
    ];
}
