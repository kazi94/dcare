<?php

namespace Database\Seeders;

use Database\Seeders\ActSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\PatientSeeder;
use Database\Seeders\AppointementSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            CabinetSeeder::class,
            ActSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            PatientSeeder::class,
            AppointementSeeder::class,
            FormulasSeeder::class,
        ]);

        $path = base_path('database/data/drugs.sql');
        DB::unprepared(file_get_contents($path));
        $this->command->info('Drugs tables seeded!');
    }
}
