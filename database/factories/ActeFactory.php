<?php


namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ActeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();

        $types = ['teeth', 'sector', 'mouth'];
        $prices = [1000, 2000, 3000, 5000, 7000, 8500, 10000, 15000];
        return [
            'code_cnas' => $faker->word(),
            'nom' => $faker->numerify('Acte ##'),
            'category_id' => Category::all()->random()->id,
            'price' => $faker->randomElement($prices),
            'type' => $faker->randomElement($types),
            'shortcut' => $faker->randomLetter(3),
        ];
    }
}
