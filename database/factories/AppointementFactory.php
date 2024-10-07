<?php


namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AppointementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $faker = \Faker\Factory::create();

        $updated_at = $faker->dateTimeBetween("-10 days", '+1 month', null);
        $created_at = $faker->dateTimeBetween("-10 days", $updated_at, null);
        $end_date = $faker->dateTimeInInterval($created_at, '+ 30 min', $timezone = null);
        return [
            'text' => $faker->paragraph($nbSentences = 1, $variableNbSentences = true),
            'start_date' => $created_at,
            'end_date' => $end_date,

            'fauteuil' => $faker->randomElement(['1', '2']),
            'state' => $faker->randomElement(['report', 'cancel', 'validate']),
            'state_modified_at' => $updated_at,
            'category_id' => \App\Models\Category::all()->random()->id,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ];
    }
}
