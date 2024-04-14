<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Nikolz',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
        ])->assignRole('Admin');

        User::create([
            'name' => 'Editor',
            'email' => 'editor@gmail.com',
            'password' => bcrypt('123456'),
        ])->assignRole('Editor');

        User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) {
                $user->assignRole('User');
            });

        User::all()->each(function ($user) {
            $user->posts()->saveMany(
                Post::factory()->count(rand(1,5))->make()
            );
        });
    }
}
