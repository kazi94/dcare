<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();

        $colors = ['#EC7C26', "#18171C", "#CAC4B0", "#F3A505", "#1C542D", "#102C54"];

        return [
            'name' => $faker->name,
            'color' => $faker->hexcolor()
        ];
    }
}
