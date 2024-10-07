<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();
        return [
            'name' => 'Admin',
            'prenom' => 'Admin',
            'profession' => 'admin',
            'email' => 'admin@dcare.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10),
            'role_id' => \App\Models\Role::first()->id,
            'color' => $faker->hexcolor(),
            'cabinet_id' => \App\Models\Cabinet::first()->id
        ];
    }
}
