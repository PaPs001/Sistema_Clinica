<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateTreatmentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'treatments:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza el estado de los tratamientos vencidos a Completado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->startOfDay();
        
        $updated = \App\Models\treatment_record::where('status', 'En seguimiento')
            ->whereDate('end_date', '<', $today)
            ->update(['status' => 'Completado']);
            
        $this->info("Se han actualizado {$updated} tratamientos a estado Completado.");
        \Illuminate\Support\Facades\Log::info("Treatments status update: {$updated} records updated to Completed.");
    }
}
