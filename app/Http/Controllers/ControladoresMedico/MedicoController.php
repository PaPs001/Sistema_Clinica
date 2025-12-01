<?php

namespace App\Http\Controllers\ControladoresMedico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\appointment;
use App\Models\patientUser;
use App\Models\vital_sign;
use App\Models\medical_records;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MedicoController extends Controller
{
    public function getWeeklyAppointments(Request $request)
    {
        try {
            $doctor = Auth::user()->medic;
            
            if (!$doctor) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró el perfil de médico'
                ], 404);
            }

            $today = Carbon::today();
            $startOfWeek = $today->copy()->startOfWeek();
            $endOfWeek = $today->copy()->endOfWeek();
            $rangeStart = $today;
            
            $searchQuery = $request->input('q', '');

            Log::info('Buscando citas semanales - DEBUG VPS', [
                'doctor_id' => $doctor->id,
                'server_timezone' => date_default_timezone_get(),
                'now_formatted' => Carbon::now()->format('Y-m-d H:i:s'),
                'today_var' => $today->toDateString(),
                'start_of_week' => $startOfWeek->toDateString(),
                'end_of_week' => $endOfWeek->toDateString(),
                'range_start' => $rangeStart->toDateString(),
                'search_query' => $searchQuery
            ]);

            $query = appointment::with(['patient.user', 'doctor.user'])
                ->where('doctor_id', $doctor->id)
                ->where('status', 'agendada')
                ->whereBetween('appointment_date', [$rangeStart->toDateString(), $endOfWeek->toDateString()]);
            
            // Filtrar por nombre de paciente si hay búsqueda
            if (!empty($searchQuery)) {
                $query->whereHas('patient', function ($q) use ($searchQuery) {
                    $q->where(function ($subQ) use ($searchQuery) {
                        // Buscar en pacientes temporales
                        $subQ->where('temporary_name', 'like', "%{$searchQuery}%")
                            // O buscar en pacientes registrados
                            ->orWhereHas('user', function ($userQ) use ($searchQuery) {
                                $userQ->where('name', 'like', "%{$searchQuery}%");
                            });
                    });
                });
            }
            
            $appointments = $query->orderBy('appointment_date', 'asc')
                ->orderBy('appointment_time', 'asc')
                ->get();

            Log::info('Citas encontradas: ' . $appointments->count());

            $formattedAppointments = $appointments->map(function ($appointment) {
                $patientName = 'Desconocido';
                $isTemporary = false;
                $age = null;
                $gender = null;
                
                if ($appointment->patient) {
                    if ($appointment->patient->is_Temporary) {
                        $patientName = $appointment->patient->temporary_name;
                        $isTemporary = true;
                    } elseif ($appointment->patient->user) {
                        $patientName = $appointment->patient->user->name;
                        $gender = $appointment->patient->user->genre;
                        
                        // Calcular edad si existe fecha de nacimiento
                        if ($appointment->patient->user->birthdate) {
                            $birthdate = Carbon::parse($appointment->patient->user->birthdate);
                            $age = $birthdate->age;
                        }
                    }
                }

                return [
                    'id' => $appointment->id,
                    'patient_name' => $patientName,
                    'patient_id' => $appointment->patient_id,
                    'is_temporary' => $isTemporary,
                    'age' => $age,
                    'gender' => $gender,
                    'date' => Carbon::parse($appointment->appointment_date)->format('d/m/Y'),
                    'time' => Carbon::parse($appointment->appointment_time)->format('H:i'),
                    'datetime' => $appointment->appointment_date . ' ' . $appointment->appointment_time,
                    'reason' => $appointment->reason ?? 'Consulta general',
                    'status' => $appointment->status,
                ];
            });

            return response()->json([
                'success' => true,
                'appointments' => $formattedAppointments
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener citas semanales: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las citas: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAppointmentPatientData($appointmentId)
    {
        try {
            $appointment = appointment::with(['patient.user'])->findOrFail($appointmentId);
            
            $patient = $appointment->patient;
            
            if (!$patient) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró el paciente asociado a la cita'
                ], 404);
            }

            $patientData = [
                'appointment_id' => $appointment->id,
                'patient_id' => $patient->id,
                'is_temporary' => (bool) $patient->is_Temporary,
                'appointment_date' => $appointment->appointment_date,
                'appointment_time' => $appointment->appointment_time,
            ];

            if ($patient->is_Temporary) {
                $patientData['nombre'] = $patient->temporary_name;
                $patientData['telefono'] = $patient->temporary_phone;
            } else {
                $user = $patient->user;
                
                if ($user) {
                    $patientData['nombre'] = $user->name;
                    $patientData['fechaNacimiento'] = $user->birthdate;
                    $patientData['genero'] = $user->genre;
                    $patientData['telefono'] = $user->phone;
                    $patientData['email'] = $user->email;
                    $patientData['direccion'] = $user->address;

                    $medicalRecord = medical_records::where('patient_id', $patient->id)->first();
                    
                    if ($medicalRecord) {
                        $patientData['smoking_status'] = $medicalRecord->smoking_status;
                        $patientData['alcohol_use'] = $medicalRecord->alcohol_use;
                        $patientData['physical_activity'] = $medicalRecord->physical_activity;
                        $patientData['special_needs'] = $medicalRecord->special_needs;
                    }

                    $vitalSigns = vital_sign::where('patient_id', $patient->id)
                        ->orderBy('created_at', 'desc')
                        ->first();
                    
                    if ($vitalSigns) {
                        $patientData['signos_vitales'] = [
                            'presionArterial' => $vitalSigns->blood_pressure,
                            'frecuenciaCardiaca' => $vitalSigns->heart_rate,
                            'temperatura' => $vitalSigns->temperature,
                            'peso' => $vitalSigns->weight,
                            'estatura' => $vitalSigns->height,
                        ];
                    }
                }
            }

            return response()->json([
                'success' => true,
                'data' => $patientData
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener datos del paciente: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los datos del paciente: ' . $e->getMessage()
            ], 500);
        }
    }
}
