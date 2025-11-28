<?php

namespace App\Http\Controllers\administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\appointment;
use App\Models\medicUser;

class AdminReportsController extends Controller
{
    public function pacientesAtendidos(Request $request)
    {
        $query = appointment::with(['patient.user', 'doctor.user', 'vitalSigns', 'consultDiseases.disease'])
            ->where('status', 'completada');

        if ($request->filled('desde')) {
            $query->whereDate('appointment_date', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('appointment_date', '<=', $request->hasta);
        }

        if ($request->filled('medic_id')) {
            $query->where('doctor_id', $request->medic_id);
        }

        $citas = $query
            ->orderBy('appointment_date', 'desc')
            ->paginate(10)
            ->withQueryString();
        $medicos = medicUser::with('user')->get();

        return view('ADMINISTRADOR.reportes-pacientes-atendidos', [
            'citas' => $citas,
            'medicos' => $medicos,
            'filtros' => $request->only('desde', 'hasta', 'medic_id'),
        ]);
    }

    public function exportPacientesAtendidos(Request $request)
    {
        $query = appointment::with(['patient.user', 'doctor.user', 'vitalSigns', 'consultDiseases.disease'])
            ->where('status', 'completada');

        if ($request->filled('desde')) {
            $query->whereDate('appointment_date', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('appointment_date', '<=', $request->hasta);
        }

        if ($request->filled('medic_id')) {
            $query->where('doctor_id', $request->medic_id);
        }

        $citas = $query
            ->orderBy('appointment_date', 'desc')
            ->get();

        $filename = 'reporte_pacientes_atendidos_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($citas) {
            $output = fopen('php://output', 'w');

            echo "\xEF\xBB\xBF";

            fputcsv($output, [
                'Fecha',
                'Hora',
                'Paciente',
                'Médico',
                'Motivo',
                'Estado',
                'Temperatura',
                'Frecuencia cardiaca',
                'Peso',
                'Altura',
                'Diagnósticos',
            ]);

            foreach ($citas as $cita) {
                $vital = $cita->vitalSigns->first();

                $diagnostics = $cita->consultDiseases
                    ->map(function ($consult) {
                        return optional($consult->disease)->name;
                    })
                    ->filter()
                    ->values()
                    ->implode(' | ');

                fputcsv($output, [
                    $cita->appointment_date,
                    $cita->appointment_time,
                    optional($cita->patient)->display_name,
                    optional(optional($cita->doctor)->user)->name,
                    $cita->reason,
                    $cita->status,
                    optional($vital)->temperature,
                    optional($vital)->heart_rate,
                    optional($vital)->weight,
                    optional($vital)->height,
                    $diagnostics,
                ]);
            }

            fclose($output);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }
}

