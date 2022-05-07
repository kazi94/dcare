<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Patient;
use Faker\Generator as Faker;

$users = \App\User::all();
$factory->define(Patient::class, function (Faker $faker) use ($users) {
    $sexes = ['M', 'F'];
    $fumeur = ['1', '0'];
    $updated_at = $faker->dateTimeBetween("-7 month", 'now', null);
    $created_at = $faker->dateTimeBetween("-7 month", $updated_at, null);
    return [
        'nom' => $faker->lastName,
        'prenom' => $faker->firstName,
        'adresse' => $faker->word(),
        'profession' => $faker->word(),
        'sexe' => $faker->randomElement($sexes),
        'motif' => $faker->paragraph($nbSentences = 1, $variableNbSentences = true),
        'motivation' => $faker->randomElement(['motivate', 'less_motivate', 'no_motivate']),
        'medecin_externe' => $faker->name,
        'fumeur' => $faker->randomElement($fumeur),
        'num_tel' => $faker->e164PhoneNumber,
        'date_naissance' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'age' => $faker->numberBetween($min = 5, $max = 90),
        'created_by' => $faker->randomElement($users)->id,
        'created_at' => $created_at,
        'updated_at' => $updated_at

    ];
});
$factory->afterCreating(Patient::class, function ($patient, $faker) use ($users) {
    $patient->quotations()->saveMany(
        factory(\App\Models\Devis::class, 2)
            ->create([
                'state' => 'devis',
                'created_by'  => $faker->randomElement($users)->id,
                'updated_by'  => $faker->randomElement($users)->id,
            ])
    );
    $patient->quotations()->saveMany(
        factory(\App\Models\Devis::class, 1)
            ->create([
                'state' => 'plan',
                'created_by'  => $faker->randomElement($users)->id,
                'updated_by'  => $faker->randomElement($users)->id,
            ])
    );
    $user = $faker->randomElement($users);
    $patient->appointements()->saveMany(
        factory(\App\Models\Appointement::class, 3)
            ->create([
                'created_by' => $faker->randomElement($users)->id,
                'updated_by'  => $faker->randomElement($users)->id,
                'assign_to' => $user->id,
                'color' => $user->color
            ])
    );
    $patient->payments()->saveMany(
        factory(\App\Models\Versement::class, 10)
            ->create([
                'paid_by' => 1
            ])
    );
});
