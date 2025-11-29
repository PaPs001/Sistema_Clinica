<?php

namespace Database\Seeders;

use App\Models\Medication;
use Illuminate\Database\Seeder;

class MedicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/Data/medicamentosData.csv');

        if (!file_exists($path)) {
            return;
        }

        $handle = fopen($path, 'r');
        if (!$handle) {
            return;
        }

        // Saltar encabezado si existe
        fgetcsv($handle, 0, ',');

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            $name = trim($row[0] ?? '');

            if ($name === '') {
                continue;
            }

            Medication::updateOrCreate(
                ['name' => $name],
                [
                    'category'        => 'Medicamento',
                    'presentation'    => 'N/A',
                    'concentration'   => 'N/A',
                    'stock'           => 0,
                    'min_stock'       => 0,
                    'expiration_date' => now()->addYear(),
                    'batch_number'    => null,
                    'provider'        => null,
                    'status'          => 'active',
                ]
            );
        }

        fclose($handle);
    }
}
