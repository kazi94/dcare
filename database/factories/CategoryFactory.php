<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $colors = ['#EC7C26', "#18171C", "#CAC4B0", "#F3A505", "#1C542D", "#102C54"];

    return [
        'name' => $faker->word(),
        'color' => $faker->hexcolor()
    ];
});
