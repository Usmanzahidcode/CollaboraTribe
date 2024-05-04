<?php

namespace Database\Factories;

use App\Models\User;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create('en_US');

        return [
            'title' => $faker->realText(100),
            'excerpt' => $faker->realText(300),
            'description' => $faker->realText(750),
            'category' => 'Web Development',
            'author_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
