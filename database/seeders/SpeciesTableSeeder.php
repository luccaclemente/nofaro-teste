<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specie;

class SpeciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        // Specie::truncate();

        $species = [
            [
                'description' => 'Cão',
                'shortDescription' => 'C'
            ],
            [
                'description' => 'Gato',
                'shortDescription' => 'G'
            ]
        ];

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < sizeof($species); $i++) {
            Specie::create([
                'description' => $species[$i]['description'],
                'shortDescription' => $species[$i]['shortDescription'],
            ]);
        }
    }
}
