<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\treatment_record;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TreatmentController extends Controller
{
    public function activeTreatments()
    {
        // Obtener pacientes con tratamientos activos
        $patients = \App\Models\UserModel::where('typeUser_id', 3) // Rol de paciente
            ->whereHas('patient.medicalRecords.treatmentRecords', function($q) {
                $q->where('status', 'En seguimiento');
            })
            ->with(['patient.medicalRecords.treatmentRecords' => function($q) {
                $q->where('status', 'En seguimiento')
                  ->with('treatment', 'medicUser'); // Cargar detalles del tratamiento y médico
            }])
            ->get();

        return view('ENFERMERA.tratamientos-activos', compact('patients'));
    }

    public function getTreatment($id)
    {
        try {
            $treatment = treatment_record::with(['treatment', 'medicUser', 'medicalRecord.patientUser.user'])
                ->findOrFail($id);

            $startDate = $treatment->start_date ? \Carbon\Carbon::parse($treatment->start_date)->format('Y-m-d') : null;
            $endDate = $treatment->end_date ? \Carbon\Carbon::parse($treatment->end_date)->format('Y-m-d') : null;
            $patientName = optional(optional(optional($treatment->medicalRecord)->patientUser)->user)->name ?? 'N/A';
            $prescribedBy = optional($treatment->medicUser)->name ?? 'N/A';
            $treatmentDescription = optional($treatment->treatment)->treatment_description ?? 'N/A';

            return response()->json([
                'success' => true,
                'treatment' => [
                    'id' => $treatment->id,
                    'patient_name' => $patientName,
                    'treatment_description' => $treatmentDescription,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'notes' => $treatment->notes,
                    'status' => $treatment->status,
                    'prescribed_by' => $prescribedBy,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener tratamiento: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el tratamiento'
            ], 500);
        }
    }

    public function updateTreatment(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:En seguimiento,Completado,suspendido',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'notes' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            $treatment = treatment_record::findOrFail($id);
            
            $treatment->update([
                'status' => $request->status,
                'end_date' => $request->end_date,
                'notes' => $request->notes,
            ]);

            Log::info('Tratamiento actualizado', [
                'treatment_id' => $id,
                'new_status' => $request->status,
                'updated_by' => auth()->user()->name ?? 'Sistema'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tratamiento actualizado exitosamente',
                'treatment' => $treatment
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar tratamiento: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el tratamiento'
            ], 500);
        }
    }
}
