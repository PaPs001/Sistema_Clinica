<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\allergie;
use League\Csv\Reader;
use App\Models\allergene;

class allergieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $path = database_path('seeders/Data/AllergyData.csv');
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        foreach($csv as $allergyData){
            allergie::firstOrCreate([
                'name' => $allergyData['Alergia'],
            ]);    
            allergene::firstOrCreate([
                'name' => $allergyData['Alergeno'],
            ]);
        }
    }
}
