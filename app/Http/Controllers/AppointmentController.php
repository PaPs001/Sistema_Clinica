<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\UserModel;
use App\Models\patientUser;
use App\Models\medicUser;
use App\Models\receptionistUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function checkPatient(Request $request)
    {
        $email = $request->input('email');
        $user = UserModel::where('email', $email)->first();

        if ($user) {
            $patient = $user->patient;
            return response()->json([
                'exists' => true,
                'name' => $user->name,
                'patient_id' => $patient ? $patient->id : null,
                'phone' => $user->phone // Useful for pre-filling
            ]);
        }

        return response()->json(['exists' => false]);
    }

    public function store(Request $request)
    {
        Log::info('AppointmentController@store: Recibiendo solicitud', $request->all());

        $request->validate([
            'email' => 'required|email',
            'doctor_name' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'type' => 'required|string',
            'notes' => 'nullable|string',
            // New patient fields if needed
            'name' => 'nullable|string|required_if:is_new,true',
            'phone' => 'nullable|string|required_if:is_new,true',
        ]);

        try {
            DB::beginTransaction();

            // 1. Handle Patient
            $user = UserModel::where('email', $request->email)->first();
            $patientId = null;

            if (!$user) {
                // Create TEMPORARY patient in patient_users
                $patient = new patientUser();
                $patient->userId = null; // No general_user linked
                $patient->DNI = 'PENDIENTE'; // Required field
                $patient->is_Temporary = true;
                $patient->temporary_name = $request->name;
                $patient->temporary_phone = $request->phone;
                $patient->userCode = 'PAT' . rand(1000, 9999);
                $patient->save();
                
                $patientId = $patient->id;
            } else {
                // User exists, check if patient record exists
                $patient = $user->patient;
                if (!$patient) {
                    $patient = new patientUser();
                    $patient->userId = $user->id;
                    $patient->DNI = 'PENDIENTE';
                    $patient->save();
                }
                $patientId = $patient->id;
            }

            // 2. Handle Doctor
            // Clean doctor name (remove Dr./Dra. prefix)
            $cleanDoctorName = preg_replace('/^(Dr\.|Dra\.)\s+/i', '', $request->doctor_name);
            
            // Search for doctor with typeUser_id = 2 (Medico)
            $doctorUser = UserModel::where('typeUser_id', 2)
                ->where('name', 'LIKE', '%' . $cleanDoctorName . '%')
                ->first();

            $doctorId = null;
            
            if ($doctorUser) {
                // Check if medic profile exists, if not create it (optional, but good for consistency)
                if (!$doctorUser->medic) {
                     // Create medic profile if it doesn't exist
                     $medic = new medicUser();
                     $medic->userId = $doctorUser->id;
                     $medic->service_ID = 1; // Default service or handle appropriately
                     $medic->save();
                     $doctorId = $medic->id;
                } else {
                    $doctorId = $doctorUser->medic->id;
                }
            } else {
                 Log::warning("Doctor not found: " . $request->doctor_name . " (Cleaned: " . $cleanDoctorName . ")");
                 throw new \Exception("Médico no encontrado: " . $request->doctor_name);
            }

            // 3. Handle Receptionist (Auth user)
            // Assuming auth is working and user is receptionist
            // $receptionistId = auth()->user()->receptionist->id ?? null;
            // For now, hardcode or nullable
            $receptionistId = null; 

            // 4. Create Appointment
            $appointment = new Appointment();
            $appointment->patient_id = $patientId;
            $appointment->doctor_id = $doctorId;
            $appointment->receptionist_id = $receptionistId;
            $appointment->services_id = 1; // Default service
            $appointment->appointment_date = $request->date;
            $appointment->appointment_time = $request->time;
            $appointment->status = 'agendada'; // Default status
            $appointment->reason = $request->type; // Using type as reason for now
            $appointment->notes = $request->notes ?? '';
            $appointment->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cita agendada exitosamente',
                'data' => $appointment
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('AppointmentController@store: Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al agendar cita: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getDoctors()
    {
        try {
            $doctors = UserModel::where('typeUser_id', 2)
                ->select('id', 'name')
                ->where('status', 'active')
                ->get();

            return response()->json([
                'success' => true,
                'doctors' => $doctors
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching doctors: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener lista de médicos'
            ], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $query = Appointment::with(['patient.user', 'doctor.user'])
                ->orderBy('appointment_date', 'desc')
                ->orderBy('appointment_time', 'asc');

            // Apply filters
            if ($request->has('date') && $request->date) {
                $query->where('appointment_date', $request->date);
            }

            if ($request->has('doctor_id') && $request->doctor_id) {
                // Filter by the doctor's USER ID (general_users id)
                // We need to query the relationship
                $query->whereHas('doctor', function ($q) use ($request) {
                    $q->where('userId', $request->doctor_id);
                });
            }

            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            $appointments = $query->get();

            $formattedAppointments = $appointments->map(function ($appointment) {
                $patientName = 'Desconocido';
                if ($appointment->patient) {
                    if ($appointment->patient->is_Temporary) {
                        $patientName = $appointment->patient->temporary_name;
                    } elseif ($appointment->patient->user) {
                        $patientName = $appointment->patient->user->name;
                    }
                }

                $doctorName = 'Por asignar';
                if ($appointment->doctor && $appointment->doctor->user) {
                    $doctorName = $appointment->doctor->user->name;
                }

                return [
                    'id' => $appointment->id,
                    'date' => $appointment->appointment_date,
                    'time' => $appointment->appointment_time,
                    'patient_name' => $patientName,
                    'doctor_name' => $doctorName,
                    'type' => $appointment->reason, // Using reason as type based on store method
                    'status' => $appointment->status,
                    'notes' => $appointment->notes,
                ];
            });

            return response()->json([
                'success' => true,
                'appointments' => $formattedAppointments
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching appointments: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener citas'
            ], 500);
        }
    }

    public function cancel($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->status = 'cancelada';
            $appointment->save();

            return response()->json([
                'success' => true,
                'message' => 'Cita cancelada exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error cancelling appointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cancelar la cita: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            // Updated to match DB enum: ['En curso', 'completada', 'cancelada', 'Sin confirmar', 'Confirmada', 'agendada']
            $request->validate([
                'status' => 'required|in:agendada,Confirmada,En curso,completada,cancelada,Sin confirmar'
            ]);

            $appointment = Appointment::findOrFail($id);
            $appointment->status = $request->status;
            $appointment->save();

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating appointment status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado'
            ], 500);
        }
    }
}
