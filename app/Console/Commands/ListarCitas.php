<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\appointment;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Log;

class ListarCitas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
        protected $signature = 'citas:listar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $citas = appointment::with('patient.user')->get();

    foreach ($citas as $cita) {
        $nombre = $cita->patient->user->name ?? 'Paciente sin usuario';
        $fecha = $cita->appointment_date;
        $hora  = $cita->appointment_time;
        Log::info("Cita registrada - Paciente: $nombre | Fecha: $fecha | Hora: $hora");
        $this->info("Cita registrada - Paciente: $nombre | Fecha: $fecha | Hora: $hora");
    }
}
}
