<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\UserModel;
use Carbon\Carbon;

class ReceptionistController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();

        // 1. Citas del Día (Appointments for today)
        $todaysAppointments = Appointment::with(['patient.user', 'doctor.user'])
            ->whereDate('appointment_date', $today)
            ->orderBy('appointment_time', 'asc')
            ->get();

        // 2. Statistics
        // Citas Hoy: Count of today's appointments
        $citasHoy = $todaysAppointments->count();

        // Nuevos Pacientes: Patients registered today
        // Assuming 'created_at' in general_users reflects registration time
        // and typeUser_id = 3 is for patients
        $nuevosPacientes = UserModel::where('typeUser_id', 3)
            ->whereDate('created_at', $today)
            ->count();

        // Completadas: Count of appointments with status 'completada' (or 'Confirmada'?)
        // User asked for "Completadas" instead of "En Espera"
        // I will count 'completada' status. If the user meant 'Confirmada' + 'completada', I can adjust.
        // Based on previous interaction, 'completada' is a valid status.
        $completadas = Appointment::where('status', 'completada')->count();

        // Canceladas: Count of appointments with status 'cancelada'
        // User asked for "Canceladas" instead of "Llamadas Pendientes"
        $canceladas = Appointment::where('status', 'cancelada')->count();

        return view('RECEPCIONISTA.dashboard-recepcionista', compact(
            'todaysAppointments',
            'citasHoy',
            'nuevosPacientes',
            'completadas',
            'canceladas'
        ));
    }
}
