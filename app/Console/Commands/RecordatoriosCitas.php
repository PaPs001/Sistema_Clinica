<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\appointment;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\RecordatorioCitaMail;

class RecordatoriosCitas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:recordatorios-citas';
    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar recordatorios de citas a los pacientes';

    /**
     * Execute the console command.
     */
    public function handle(){
        //$diaRecordatorio = Carbon::tomorrow()->toDateString();
        $diaRecordatorio = '2025-11-24';
        
        $this->info("Buscando citas para: " . $diaRecordatorio);
        
        $citas = appointment::whereDate('appointment_date', $diaRecordatorio)
            ->where('status', 'agendada')
            ->whereHas('patient', function ($q) {
                $q->where('is_Temporary', false);
            })
            ->with(['patient.user' => function ($query) {
                $query->whereNotNull('email');
            }])
            ->get();

        $this->info("Citas encontradas: " . $citas->count());
        
        $enviados = 0;
        foreach ($citas as $cita) {
            if ($cita->patient && $cita->patient->user && $cita->patient->user->email) {
                try {
                    Mail::to($cita->patient->user->email)
                        ->send(new RecordatorioCitaMail(
                            $cita->patient->user->name,
                            $cita->appointment_date,
                            $cita->appointment_time
                        ));
                    $enviados++;
                    $this->info("Correo enviado a: " . $cita->patient->user->email);
                } catch (\Exception $e) {
                    $this->error("Error enviando correo: " . $e->getMessage());
                }
            } else {
                $this->warn("Paciente sin email válido: " . ($cita->patient->id ?? 'Desconocido'));
            }
        }
        $this->info("Total recordatorios enviados: " . $enviados);
    }
}