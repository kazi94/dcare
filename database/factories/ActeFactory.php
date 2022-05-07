<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Acte;
use Faker\Generator as Faker;

$factory->define(Acte::class, function (Faker $faker) {
    $types = ['teeth', 'sector', 'mouth'];
    $prices = [1000, 2000, 3000, 5000, 7000, 8500, 10000, 15000];
    return [
        'code_cnas' => $faker->word(),
        'nom' => $faker->numerify('Acte ##'),
        // 'category_id' =>  function () {
        //     return factory(App\Category::class)->create()->id;
        // },
        'price' => $faker->randomElement($prices),
        'type' => $faker->randomElement($types),
        'shortcut' => $faker->text(10),
    ];
});

// $factory->afterCreating(Acte::class, function ($act, $faker) {
//     $act->coords()->save(factory(App\Account::class)->make());
// });
