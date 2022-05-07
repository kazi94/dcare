<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Versement;
use Faker\Generator as Faker;

$factory->define(Versement::class, function (Faker $faker) {
    $prices = [1000, 2000, 3000, 5000, 7000, 8500, 10000, 15000];
    $paid_at = $faker->dateTimeBetween("-11 months", 'now', null);

    return [
        'total_paid' => $faker->randomElement($prices),
        'paid_at' => $paid_at,
    ];
});
