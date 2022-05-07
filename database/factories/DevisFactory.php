<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Devis;
use Faker\Generator as Faker;

$users = \App\User::all()->map->id;
$factory->define(Devis::class, function (Faker $faker) use ($users) {
    $updated_at = $faker->dateTimeBetween("-7 month", 'now', null);
    $created_at = $faker->dateTimeBetween("-7 month", $updated_at, null);
    return [
        'state'  => $faker->randomElement(['devis', 'plan']),
        'discount'  => 0,
        'total' => 0,
        'total_accept'  => 0,
        'created_at'  => $created_at,
        'updated_at' => $updated_at
    ];
});
$factory->afterCreating(Devis::class, function ($devis, $faker) {

    if ($devis->state == "devis") {
        $devis->lines()->saveMany(factory(App\Models\LigneDevis::class, 5)->create([
            'devis_id' => $devis->id,
        ]));
    }
    if ($devis->state == "plan") {
        $devis->lines()->saveMany(factory(App\Models\LigneDevis::class, 10)->create([
            'state' => 'fait',
            'devis_id' => $devis->id
        ]));
        $devis->lines()->saveMany(factory(App\Models\LigneDevis::class, 10)->create([
            'state' => $faker->randomElement(['En cours', 'A faire']),
            'devis_id' => $devis->id
        ]));
    }
});
