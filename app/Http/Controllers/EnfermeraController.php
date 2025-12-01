<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EnfermeraController extends Controller
{
    // ==================== SIGNOS VITALES ====================
    
    public function getSignos(Request $request)
    {
        try {
            $query = DB::table('vital_signs')
                ->join('patient_users', 'vital_signs.patient_id', '=', 'patient_users.id')
                ->join('general_users', 'patient_users.userId', '=', 'general_users.id')
                ->select(
                    'vital_signs.*',
                    'general_users.name as patient_name'
                );

            // Filtros
            if ($request->has('patient_id') && $request->patient_id != '') {
                $query->where('vital_signs.patient_id', $request->patient_id);
            }

            if ($request->has('date_filter')) {
                $today = Carbon::today();
                switch ($request->date_filter) {
                    case 'today':
                        $query->whereDate('vital_signs.created_at', $today);
                        break;
                    case 'week':
                        $query->whereBetween('vital_signs.created_at', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()]);
                        break;
                    case 'month':
                        $query->whereMonth('vital_signs.created_at', $today->month);
                        break;
                }
            }

            $signos = $query->orderBy('vital_signs.created_at', 'desc')->get();

            return response()->json($signos);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function storeSignos(Request $request)
    {
        try {
            $validated = $request->validate([
                'patient_id' => 'required|exists:patient_users,id',
                'blood_pressure' => 'required|string',
                'heart_rate' => 'required|integer',
                'temperature' => 'required|numeric',
                'respiratory_rate' => 'required|integer',
                'oxygen_saturation' => 'required|numeric',
                'notes' => 'nullable|string',
            ]);

            // Buscar la cita más reciente del paciente para vincular los signos vitales
            $appointmentId = DB::table('appointments')
                ->where('patient_id', $validated['patient_id'])
                ->orderByDesc('appointment_date')
                ->orderByDesc('appointment_time')
                ->value('id');

            if (!$appointmentId) {
                return response()->json([
                    'message' => 'El paciente no tiene citas registradas para asociar los signos vitales.'
                ], 422);
            }

            $id = DB::table('vital_signs')->insertGetId([
                'patient_id' => $validated['patient_id'],
                'blood_pressure' => $validated['blood_pressure'],
                'heart_rate' => $validated['heart_rate'],
                'temperature' => $validated['temperature'],
                'respiratory_rate' => $validated['respiratory_rate'],
                'oxygen_saturation' => $validated['oxygen_saturation'],
                'register_by' => 1, // TODO: Get from auth
                'register_date' => $appointmentId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['message' => 'Signos vitales registrados correctamente', 'id' => $id], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al registrar signos vitales: ' . $e->getMessage()], 500);
        }
    }

    public function updateSignos(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'blood_pressure' => 'required|string',
                'heart_rate' => 'required|integer',
                'temperature' => 'required|numeric',
                'respiratory_rate' => 'required|integer',
                'oxygen_saturation' => 'required|numeric',
                'weight' => 'nullable|numeric',
                'height' => 'nullable|numeric',
            ]);

            DB::table('vital_signs')
                ->where('id', $id)
                ->update([
                    'blood_pressure' => $validated['blood_pressure'],
                    'heart_rate' => $validated['heart_rate'],
                    'temperature' => $validated['temperature'],
                    'respiratory_rate' => $validated['respiratory_rate'],
                    'oxygen_saturation' => $validated['oxygen_saturation'],
                    'weight' => $validated['weight'] ?? null,
                    'height' => $validated['height'] ?? null,
                    'updated_at' => now(),
                ]);

            return response()->json(['message' => 'Signos vitales actualizados correctamente']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function deleteSignos($id)
    {
        try {
            DB::table('vital_signs')->where('id', $id)->delete();
            return response()->json(['message' => 'Registro eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    // ==================== TRATAMIENTOS ====================
    
    public function getTratamientos(Request $request)
    {
        try {
            $query = DB::table('treatments_records')
                ->join('treatments', 'treatments_records.treatment_id', '=', 'treatments.id')
                ->join('medical_records', 'treatments_records.id_record', '=', 'medical_records.id')
                ->join('patient_users', 'medical_records.patient_id', '=', 'patient_users.id')
                ->join('general_users', 'patient_users.userId', '=', 'general_users.id')
                ->leftJoin('medic_users', 'treatments_records.prescribed_by', '=', 'medic_users.id')
                ->leftJoin('general_users as medic_general', 'medic_users.userId', '=', 'medic_general.id')
                ->select(
                    'treatments_records.*',
                    'general_users.name as paciente',
                    'treatments.treatment_description as medicamento',
                    'medic_general.name as medico'
                );

            // Filtros
            if ($request->has('status') && $request->status != 'todos') {
                $query->where('treatments_records.status', $request->status);
            }

            $tratamientos = $query->orderBy('treatments_records.created_at', 'desc')->get();

            return response()->json($tratamientos);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function storeTratamiento(Request $request)
    {
        try {
            $validated = $request->validate([
                'patient_id' => 'required|exists:patient_users,id',
                'prescribed_by' => 'required|exists:medic_users,id',
                'treatment_name' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'notes' => 'nullable|string',
                'status' => 'nullable|string',
            ]);

            // Primero, obtener o crear el registro médico del paciente
            $medicalRecord = DB::table('medical_records')
                ->where('patient_id', $validated['patient_id'])
                ->first();

            if (!$medicalRecord) {
                // Crear un registro médico si no existe
                $recordId = DB::table('medical_records')->insertGetId([
                    'patient_id' => $validated['patient_id'],
                    'creation_date' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $recordId = $medicalRecord->id;
            }

            // Crear o buscar el tratamiento
            $treatment = DB::table('treatments')
                ->where('treatment_description', $validated['treatment_name'])
                ->first();

            if (!$treatment) {
                $treatmentId = DB::table('treatments')->insertGetId([
                    'treatment_description' => $validated['treatment_name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $treatmentId = $treatment->id;
            }

            // Crear el registro de tratamiento
            $id = DB::table('treatments_records')->insertGetId([
                'id_record' => $recordId,
                'treatment_id' => $treatmentId,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'notes' => $validated['notes'] ?? '',
                'status' => $validated['status'] ?? 'En seguimiento',
                'prescribed_by' => $validated['prescribed_by'],
                'appointment_id' => 1, // TODO: Get from actual appointment
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'message' => 'Tratamiento registrado correctamente',
                'id' => $id
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al guardar tratamiento: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateTratamiento(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'treatment_name' => 'sometimes|required|string',
                'start_date' => 'sometimes|required|date',
                'end_date' => 'sometimes|nullable|date',
                'notes' => 'sometimes|nullable|string',
                'status' => 'sometimes|required|in:En seguimiento,Completado,suspendido',
                'prescribed_by' => 'sometimes|nullable|exists:medic_users,id'
            ]);

            $updateData = ['updated_at' => now()];

            // Si cambian el nombre del tratamiento, buscamos/creamos y actualizamos el FK
            if (isset($validated['treatment_name'])) {
                $existingTreatment = DB::table('treatments')
                    ->where('treatment_description', $validated['treatment_name'])
                    ->first();

                $treatmentId = $existingTreatment
                    ? $existingTreatment->id
                    : DB::table('treatments')->insertGetId([
                        'treatment_description' => $validated['treatment_name'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                $updateData['treatment_id'] = $treatmentId;
            }

            if (isset($validated['start_date'])) {
                $updateData['start_date'] = $validated['start_date'];
            }

            if (array_key_exists('end_date', $validated)) {
                $updateData['end_date'] = $validated['end_date'];
            }

            if (array_key_exists('notes', $validated)) {
                $updateData['notes'] = $validated['notes'];
            }

            if (isset($validated['status'])) {
                $updateData['status'] = $validated['status'];
            }

            if (array_key_exists('prescribed_by', $validated)) {
                $updateData['prescribed_by'] = $validated['prescribed_by'];
            }

            DB::table('treatments_records')
                ->where('id', $id)
                ->update($updateData);

            return response()->json(['message' => 'Tratamiento actualizado']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function deleteTratamiento($id)
    {
        try {
            DB::table('treatments_records')->where('id', $id)->delete();
            return response()->json(['message' => 'Tratamiento eliminado']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Citas del día (o rango) para la pantalla de signos vitales.
     * Devuelve las citas junto con paciente y médico para que la enfermera
     * pueda registrar signos vitales ligados a una cita específica.
     */
    public function getCitasParaSignos(Request $request)
    {
        try {
            $query = DB::table('appointments')
                ->join('patient_users', 'appointments.patient_id', '=', 'patient_users.id')
                ->join('general_users as patient_general', 'patient_users.userId', '=', 'patient_general.id')
                ->join('medic_users', 'appointments.doctor_id', '=', 'medic_users.id')
                ->join('general_users as medic_general', 'medic_users.userId', '=', 'medic_general.id')
                ->select(
                    'appointments.id',
                    'appointments.appointment_date',
                    'appointments.appointment_time',
                    'appointments.status',
                    'patient_users.id as patient_id',
                    'patient_general.name as paciente',
                    'medic_users.id as doctor_id',
                    'medic_general.name as medico'
                );

            // Filtro por fecha (hoy, semana, mes)
            $today = Carbon::today();
            if ($request->has('date_filter')) {
                switch ($request->date_filter) {
                    case 'today':
                        $query->whereDate('appointments.appointment_date', $today);
                        break;
                    case 'week':
                        $query->whereBetween('appointments.appointment_date', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()]);
                        break;
                    case 'month':
                        $query->whereMonth('appointments.appointment_date', $today->month);
                        break;
                }
            } else {
                $query->whereDate('appointments.appointment_date', $today);
            }

            // Filtro opcional por paciente
            if ($request->has('patient_id') && $request->patient_id !== '') {
                $query->where('appointments.patient_id', $request->patient_id);
            }

            // Solo citas agendadas por defecto
            if ($request->has('status') && $request->status !== 'todos') {
                $query->where('appointments.status', $request->status);
            } else {
                $query->where('appointments.status', 'agendada');
            }

            $citas = $query
                ->orderBy('appointments.appointment_date')
                ->orderBy('appointments.appointment_time')
                ->get();

            return response()->json($citas);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ==================== CITAS ====================
    
    public function getCitas(Request $request)
    {
        try {
            $query = DB::table('appointments')
                ->join('patient_users', 'appointments.patient_id', '=', 'patient_users.id')
                ->join('general_users as patient_general', 'patient_users.userId', '=', 'patient_general.id')
                ->join('medic_users', 'appointments.doctor_id', '=', 'medic_users.id')
                ->join('general_users as medic_general', 'medic_users.userId', '=', 'medic_general.id')
                ->join('services', 'medic_users.service_ID', '=', 'services.id')
                ->select(
                    'appointments.*',
                    'patient_general.name as paciente',
                    'medic_general.name as medico',
                    'services.name as especialidad',
                    'medic_users.specialty'
                );

            // Filtro por fecha
            if ($request->has('date')) {
                $query->whereDate('appointments.appointment_date', $request->date);
            } else {
                $query->whereDate('appointments.appointment_date', Carbon::today());
            }

            // Filtro por estado
            if ($request->has('status') && $request->status != 'todos') {
                $query->where('appointments.status', $request->status);
            }

            $citas = $query->orderBy('appointments.appointment_time')->get();

            return response()->json($citas);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function storeCita(Request $request)
    {
        try {
            $validated = $request->validate([
                'patient_id' => 'required|exists:patient_users,id',
                'doctor_id' => 'required|exists:medic_users,id',
                'services_id' => 'required|exists:services,id',
                'appointment_date' => 'required|date',
                'appointment_time' => 'required',
                'reason' => 'required|string',
                'notes' => 'nullable|string',
                'status' => 'nullable|string',
            ]);

            $id = DB::table('appointments')->insertGetId([
                'patient_id' => $validated['patient_id'],
                'doctor_id' => $validated['doctor_id'],
                'services_id' => $validated['services_id'],
                'appointment_date' => $validated['appointment_date'],
                'appointment_time' => $validated['appointment_time'],
                'reason' => $validated['reason'],
                'notes' => $validated['notes'] ?? '',
                'status' => $validated['status'] ?? 'agendada',
                'receptionist_id' => 1, // TODO: Get from auth
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['message' => 'Cita creada correctamente', 'id' => $id], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function updateCita(Request $request, $id)
    {
        try {
            $data = $request->all();
            $data['updated_at'] = now();
            
            DB::table('appointments')->where('id', $id)->update($data);

            return response()->json(['message' => 'Cita actualizada']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function deleteCita($id)
    {
        try {
            DB::table('appointments')->where('id', $id)->delete();
            return response()->json(['message' => 'Cita eliminada']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    // ==================== PACIENTES ====================
    
    public function getPacientes(Request $request)
    {
        try {
            $query = DB::table('patient_users')
                ->join('general_users', 'patient_users.userId', '=', 'general_users.id')
                ->select(
                    'patient_users.*',
                    'general_users.name',
                    'general_users.birthdate',
                    'general_users.phone',
                    'general_users.email',
                    'general_users.address',
                    'general_users.genre'
                );

            $pacientes = $query->get();

            return response()->json($pacientes);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getHistorialPaciente($id)
    {
        try {
            // Obtener signos vitales
            $signos = DB::table('vital_signs')
                ->where('patient_id', $id)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            // Obtener tratamientos
            $tratamientos = DB::table('treatments_records')
                ->join('medical_records', 'treatments_records.id_record', '=', 'medical_records.id')
                ->where('medical_records.patient_id', $id)
                ->orderBy('treatments_records.created_at', 'desc')
                ->limit(10)
                ->get();

            return response()->json([
                'signos' => $signos,
                'tratamientos' => $tratamientos
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ==================== DASHBOARD ====================
    
    public function getAlertas()
    {
        try {
            // Mock data for now
            $alertas = [
                [
                    'id' => 1,
                    'tipo' => 'critical',
                    'titulo' => 'Presión Arterial Crítica',
                    'paciente' => 'Carlos Ruiz',
                    'lectura' => '180/110 mmHg',
                    'hora' => '10:30 AM'
                ]
            ];

            return response()->json($alertas);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getTareas()
    {
        try {
            // Mock data for now
            $tareas = [
                [
                    'id' => 1,
                    'titulo' => 'Administrar insulina',
                    'paciente' => 'Miguel Torres',
                    'habitacion' => '102',
                    'hora' => '12:00 PM',
                    'status' => 'overdue'
                ]
            ];

            return response()->json($tareas);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ==================== REPORTES ====================
    
    public function generarReporte(Request $request)
    {
        try {
            $tipo = $request->input('tipo', 'pacientes');
            $formato = $request->input('formato', 'pdf');

            // Genera un archivo de ejemplo para que el front pueda descargarlo
            $url = $this->crearArchivoTemporal($tipo, $formato);

            return response()->json([
                'message' => 'Reporte generado',
                'tipo' => $tipo,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function exportarDatos(Request $request)
    {
        try {
            $tipo = $request->input('tipo', 'todos');
            $formato = $request->input('formato', 'xlsx');

            $url = $this->crearArchivoTemporal($tipo, $formato);

            return response()->json([
                'message' => 'Datos exportados',
                'url' => $url
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function crearArchivoTemporal(string $tipo, string $formato = 'pdf'): string
    {
        $safeTipo = Str::slug($tipo) ?: 'reporte';
        $safeFormato = Str::slug($formato) ?: 'pdf';
        $filename = "reporte_{$safeTipo}_" . now()->format('Ymd_His') . ".{$safeFormato}";

        Storage::disk('public')->makeDirectory('exports');
        Storage::disk('public')->put(
            "exports/{$filename}",
            "Reporte de {$tipo}\nGenerado: " . now()->toDateTimeString() . "\nFormato: {$safeFormato}\nEste es un archivo de ejemplo."
        );

        return Storage::url("exports/{$filename}");
    }

    // ==================== UTILIDADES ====================
    
    public function getMedicos()
    {
        try {
            $medicos = DB::table('medic_users')
                ->join('general_users', 'medic_users.userId', '=', 'general_users.id')
                ->select('medic_users.id', 'general_users.name', 'medic_users.specialty')
                ->get();

            return response()->json($medicos);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getServicios()
    {
        try {
            $servicios = DB::table('services')->get();
            return response()->json($servicios);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
