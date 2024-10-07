<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormulasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = glob(base_path('schemas/formules/*.json'));
        foreach ($files as $file) {
            $data = json_decode(file_get_contents($file), true);
            foreach ($data as $item) {
                \App\Models\Formule::create($item + ['opacity' => 0]);
            }
        }

    }
}
