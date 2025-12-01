<?php

namespace App\Http\Controllers\ControladoresPaciente;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PacienteDashboardController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $patient = $user->patient;

        $medics = collect();
        $lastAppointment = null;
        $lastVitals = null;

        if ($patient) {
            $appointments = $patient->appointments()
                ->with(['doctor.user', 'doctor.service'])
                ->orderByDesc('appointment_date')
                ->orderByDesc('appointment_time')
                ->get();

            $lastAppointment = $appointments->first();

            $medics = $appointments
                ->pluck('doctor')
                ->filter()
                ->unique('id')
                ->values();

            $lastVitals = $patient->vitalSigns()
                ->orderByDesc('created_at')
                ->first();
        }

        return view('PACIENTE.dashboard-paciente', compact('user', 'patient', 'medics', 'lastAppointment', 'lastVitals'));
    }
}
