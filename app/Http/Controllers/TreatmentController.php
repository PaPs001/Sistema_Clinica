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
            ->with(['patient.medicalRecords' => function($q) {
                $q->with(['consultDiseases.medications']); // Cargar consultas y sus medicamentos
            }, 'patient.medicalRecords.treatmentRecords' => function($q) {
                $q->where('status', 'En seguimiento')
                  ->with(['treatment', 'medicUser.user']); // Cargar tratamiento y usuario médico
            }])
            ->get();

        return view('ENFERMERA.tratamientos-activos', compact('patients'));
    }

    public function getTreatment($id)
    {
        try {
            $treatment = treatment_record::with(['treatment', 'medicUser.user', 'medicalRecord.patientUser.user'])
                ->findOrFail($id);

            $startDate = $this->parseDateOrNull($treatment->start_date);
            $endDate = $this->parseDateOrNull($treatment->end_date);
            $patientName = optional(optional(optional($treatment->medicalRecord)->patientUser)->user)->name ?? 'N/A';
            $prescribedBy = optional(optional($treatment->medicUser)->user)->name ?? 'N/A';
            $treatmentDescription = optional($treatment->treatment)->treatment_description ?? 'N/A';

            // Obtener medicamentos de la consulta asociada
            $medications = [];
            // Intentar buscar la consulta por appointment_id si existe
            $consult = null;
            if ($treatment->appointment_id) {
                $consult = \App\Models\consult_disease::where('appointment_id', $treatment->appointment_id)->first();
            }
            
            // Si no se encuentra por appointment_id, buscar la última consulta del expediente que tenga medicamentos
            if (!$consult) {
                $consult = \App\Models\consult_disease::where('id_medical_record', $treatment->id_record)
                    ->whereHas('medications')
                    ->latest()
                    ->first();
            }

            if ($consult) {
                $medications = $consult->medications->map(function($med) {
                    return [
                        'id' => $med->id,
                        'name' => $med->name,
                        'presentation' => $med->presentation
                    ];
                });
            }

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
                    'medications' => $medications,
                    'consult_disease_id' => $consult ? $consult->id : null
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
                'treatment_description' => 'required|string',
                'medications' => 'nullable|array',
                'medications.*' => 'exists:medications,id',
                'consult_disease_id' => 'nullable|exists:consult_disease,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            $treatmentRecord = treatment_record::findOrFail($id);
            
            // Actualizar estado y notas
            $treatmentRecord->update([
                'status' => $request->status,
                'end_date' => $request->end_date,
                'notes' => $request->notes,
            ]);

            // Actualizar descripción del tratamiento
            if ($treatmentRecord->treatment) {
                $treatmentRecord->treatment->update([
                    'treatment_description' => $request->treatment_description
                ]);
            }

            // Actualizar medicamentos si se proporciona consult_disease_id
            if ($request->has('consult_disease_id') && $request->consult_disease_id) {
                $consult = \App\Models\consult_disease::find($request->consult_disease_id);
                if ($consult) {
                    $consult->medications()->sync($request->medications ?? []);
                }
            }

            Log::info('Tratamiento actualizado', [
                'treatment_id' => $id,
                'new_status' => $request->status,
                'updated_by' => auth()->user()->name ?? 'Sistema'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tratamiento actualizado exitosamente',
                'treatment' => $treatmentRecord
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar tratamiento: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el tratamiento'
            ], 500);
        }
    }

    private function parseDateOrNull($value)
    {
        if (!$value) {
            return null;
        }
        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            Log::warning('Fecha de tratamiento no válida', ['value' => $value]);
            return null;
        }
    }
}
