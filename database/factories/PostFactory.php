<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::pluck('id')->toArray();

        return [
            'title' => $this->faker->sentence(6,true),
            'body' => $this->faker->realText(201),
            'views' => rand(0,1500),
            'author' => $this->faker->randomElement($userIds),
            'published_date' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
