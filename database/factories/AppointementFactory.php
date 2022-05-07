<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Appointement;
use Faker\Generator as Faker;

$cats = \App\Models\Category::all()->map->id;

$factory->define(Appointement::class, function (Faker $faker) use ($cats) {

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
        'category_id' => $faker->randomElement($cats),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
