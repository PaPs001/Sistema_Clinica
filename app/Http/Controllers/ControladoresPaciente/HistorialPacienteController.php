<?php

namespace App\Http\Controllers\ControladoresPaciente;

use Illuminate\Support\Facades\Auth;
use App\Models\patientUser;
use App\Models\fileRecord;
use App\Models\appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\medicalRecord;
use App\Models\medicUser;
use App\Models\medical_records;
use App\Models\treatment_record;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistorialPacienteController extends Controller
{
    //
    public function datosConsulta(){
        $user = Auth::user();
        $patient = $user->patient;

        if (!$patient) {
            return response()->json([]);
        }

        $appointments = $patient->appointments()
            ->with([
                'doctor.user',
                'services',
                'consultDiseases.disease',
                'consultDiseases.medications',
            ])
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->get();

        $treatmentsByAppointment = treatment_record::whereIn('appointment_id', $appointments->pluck('id')->filter())
            ->with('treatment')
            ->get()
            ->groupBy('appointment_id');

        $consultas = $appointments->map(function($cita) use ($treatmentsByAppointment){
            $primeraConsulta = $cita->consultDiseases->first();

            $medications = [];
            if ($primeraConsulta && $primeraConsulta->medications) {
                $medications = $primeraConsulta->medications->map(function ($med) {
                    return $med->name ?? '';
                })->filter()->values()->all();
            }

            $treatments = $treatmentsByAppointment->get($cita->id, collect())->map(function ($tr) {
                return [
                    'descripcion' => $tr->treatment->treatment_description ?? 'Tratamiento',
                    'tipo' => $tr->treatment->type ?? null,
                    'inicio' => optional($tr->start_date)->toDateString(),
                    'fin' => optional($tr->end_date)->toDateString(),
                    'estado' => $tr->status,
                ];
            })->values()->all();

            return [
                'servicio' => $cita->services->name ?? 'Sin servicio',
                'fecha' => $cita->appointment_date,
                'doctor' => $cita->doctor->user->name ?? 'No asignado',
                'diagnostico' => $primeraConsulta?->disease->name ?? 'Sin diagn�stico',
                'tratamiento' => $primeraConsulta->treatment_diagnosis ?? 'Sin tratamiento',
                'sintomas' => $primeraConsulta->symptoms ?? '',
                'razon' => $primeraConsulta->reason ?? '',
                'revision' => $primeraConsulta->findings ?? '',
                'medicamentos' => $medications,
                'tratamientos_detalle' => $treatments,
            ];
        });

        return response()->json($consultas);
    }

    public function archivosHistorialMedico()
    {
        $user = Auth::user();

        $expediente = $user->patient->medicalRecords()->first();
        if (!$expediente) {
            return response()->json([
                'data' => [],
                'current_page' => 1,
                'last_page' => 1,
                'total' => 0,
            ]);
        }
        $fileRecord = $expediente->files()->paginate(5);

        return response()->json([
            'data' => $fileRecord->items(),
            'pagination' => (string) $fileRecord->onEachSide(1)->links('plantillas.pagination'),
            'current_page' => $fileRecord->currentPage(),
            'last_page' => $fileRecord->lastPage(),
            'total' => $fileRecord->total(),
        ]);
    }

    public function datosAntecedentesMedicos()
    {
        $user = Auth::user();

        $expediente = $user->patient->medicalRecords()->first();

        if (!$expediente) {
            return response()->json([
                'data' => [],
                'pagination' => '',
                'current_page' => 1,
                'last_page' => 1,
                'total' => 0,
            ]);
        }

        $alergias = $expediente->allergies()
            ->with([
                'allergieAllergene.allergene',
                'allergieAllergene.allergie',
            ])
            ->paginate(5);

        return response()->json([
            'data' => $alergias->items(),
            'pagination' => (string) $alergias->onEachSide(1)->links('plantillas.pagination'),
            'current_page' => $alergias->currentPage(),
            'last_page' => $alergias->lastPage(),
            'total' => $alergias->total(),
        ]);
    }

    public function verArchivo($id)
    {
        $fileRecord = fileRecord::findOrFail($id);
        $ruta = storage_path('app/public/' . $fileRecord->route);

        if (!file_exists($ruta)) {
            abort(404);
        }

        $mimeType = mime_content_type($ruta);
        return response()->file($ruta, [
            'Content-Type' => $mimeType,
        ]);
    }

    public function descargarArchivos($id)
    {
        $fileRecord = fileRecord::findOrFail($id);
        $ruta = storage_path('app/public/' . $fileRecord->route);

        if (!file_exists($ruta)) {
            abort(404);
        }

        return response()->download($ruta, $fileRecord->file_name);
    }

    public function listarProximasConsultas(Request $request)
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            return response()->json([
                'data' => [],
                'pagination' => '',
                'current_page' => 1,
                'last_page' => 1,
            ]);
        }

        $query = appointment::where('patient_id', $patient->id)
            ->where('appointment_date', '>=', Carbon::today()->toDateString())
            ->where('status', 'agendada')
            ->with(['doctor', 'doctor.service', 'doctor.user']);

        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->input('doctor_id'));
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->input('date'));
        }

        $proximasCitas = $query
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->paginate(5);

        return response()->json([
            'data' => $proximasCitas->items(),
            'current_page' => $proximasCitas->currentPage(),
            'last_page' => $proximasCitas->lastPage(),
            'pagination' => view('plantillas.pagination', ['paginator' => $proximasCitas])->render(),
        ]);
    }

    public function dashboard()
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

    public function tratamientosActivosPaciente(Request $request)
    {
        $user = Auth::user();
        $patient = $user->patient;

        if (!$patient) {
            return response()->json([
                'data' => [],
                'pagination' => '',
                'current_page' => 1,
                'last_page' => 1,
                'total' => 0,
            ]);
        }

        $record = $patient->medicalRecords()->first();
        if (!$record) {
            return response()->json([
                'data' => [],
                'pagination' => '',
                'current_page' => 1,
                'last_page' => 1,
                'total' => 0,
            ]);
        }

        $today = Carbon::today()->toDateString();

        $query = $record->treatmentRecords()->with('treatment');

        $query->where(function ($q) use ($today) {
            $q->whereNull('end_date')
              ->orWhere('end_date', '>=', $today);
        });

        $paginator = $query
            ->orderByDesc('start_date')
            ->paginate(5);

        $items = $paginator->getCollection()->map(function ($tr) {
            return [
                'id' => $tr->id,
                'treatment' => $tr->treatment->treatment_description ?? 'Tratamiento',
                'type' => $tr->treatment->type ?? null,
                'start_date' => optional($tr->start_date)->toDateString(),
                'end_date' => optional($tr->end_date)->toDateString(),
                'status' => $tr->status,
            ];
        });

        $paginator->setCollection($items);

        return response()->json([
            'data' => $paginator->items(),
            'pagination' => view('plantillas.pagination', ['paginator' => $paginator])->render(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'total' => $paginator->total(),
        ]);
    }
}
