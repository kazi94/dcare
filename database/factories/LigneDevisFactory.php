<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\LigneDevis;
use Faker\Generator as Faker;

$acts = \App\Models\Acte::all()->map->id;
$factory->define(LigneDevis::class, function (Faker $faker) use ($acts) {
    $updated_at = $faker->dateTimeBetween("-2 years", 'now', null);
    $created_at = $faker->dateTimeBetween("-2 years", $updated_at, null);
    $tooth = [11, 12, 13, 14, 15, 16, 17, 18, 21, 22, 23, 24, 25, 26, 27, 28, 41, 42, 43, 44, 45, 46, 47, 48, 31, 32, 33, 34, 35, 36, 37, 38];
    $prices = [1000, 2000, 3000, 5000, 7000, 8500, 10000, 15000];
    return [
        'state'  => $faker->randomElement(['fait', 'A faire', 'En cours']),
        'acte_id' => $faker->randomElement($acts),
        'num_dent'  => $faker->randomElement($tooth),
        'accepted_state' => $faker->randomElement(['1', '0']),
        'price'  => $faker->randomElement($prices),
        'created_at'  => $created_at,
        'updated_at' => $updated_at
    ];
});
$factory->afterCreating(LigneDevis::class, function ($lignedevis, $faker) {
    $price = $lignedevis->price;
    $devis_id = $lignedevis->devis_id;
    $devis = \App\Models\Devis::find($devis_id);
    $devis->total = $devis->total + $price;
    $devis->total_accept = $lignedevis->accepted_state ? $devis->total_accept + $lignedevis->price : $devis->total_accept;
    $devis->save();
});
