<?php

namespace App\Http\Controllers;

use App\Models\appointment;
use App\Models\UserModel;
use App\Models\patientUser;
use App\Models\medicUser;
use App\Models\receptionistUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;
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
            'doctor_id' => 'required|exists:general_users,id',
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
                Log::info('Creating temporary patient for: ' . $request->name);
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
                Log::info('Found existing user: ' . $user->email);
                // User exists, check if patient record exists
                $patient = $user->patient;
                if (!$patient) {
                    Log::info('Creating patient profile for user: ' . $user->id);
                    $patient = new patientUser();
                    $patient->userId = $user->id;
                    $patient->DNI = 'PENDIENTE';
                    $patient->save();
                }
                $patientId = $patient->id;
            }

            // 2. Handle Doctor
            Log::info('--------------------------------------------------');
            Log::info('AppointmentController@store: Buscando médico');
            Log::info('ID recibido del frontend: ' . $request->doctor_id);
            
            // Search for doctor by User ID (general_users id)
            $doctorUser = UserModel::where('id', $request->doctor_id)
                ->where('typeUser_id', 2) // Ensure it is a medic
                ->first();

            $doctorId = null;
            
            if ($doctorUser) {
                Log::info('Médico encontrado en tabla general_users (UserModel).');
                Log::info('Nombre: ' . $doctorUser->name);
                Log::info('ID (general_users): ' . $doctorUser->id);
                
                // Check if medic profile exists, if not create it
                if (!$doctorUser->medic) {
                     Log::info('Perfil médico (medic_users) NO encontrado. Creando uno nuevo...');
                     $medic = new medicUser();
                     $medic->userId = $doctorUser->id;
                     $medic->service_ID = 1; // Default service
                     $medic->save();
                     $doctorId = $medic->id;
                     Log::info('Nuevo perfil médico creado en medic_users. ID: ' . $doctorId);
                } else {
                    $doctorId = $doctorUser->medic->id;
                    Log::info('Perfil médico encontrado en medic_users. ID: ' . $doctorId);
                }
            } else {
                 Log::warning("Médico NO encontrado en general_users con ID: " . $request->doctor_id . " y typeUser_id = 2");
                 throw new \Exception("Médico no encontrado.");
            }

            // 3. Handle Receptionist (Auth user)
            // Assuming auth is working and user is receptionist
            // $receptionistId = auth()->user()->receptionist->id ?? null;
            // For now, hardcode or nullable
            $receptionistId = null; 

            // 4. Create Appointment
            Log::info('Creating appointment with Patient ID: ' . $patientId . ', Doctor ID: ' . $doctorId);
            $appointment = new appointment();
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

            Log::info('Appointment created successfully: ' . $appointment->id);

            // Notify Doctor
            if ($appointment->doctor && $appointment->doctor->user) {
                Notification::create([
                    'sender_id' => auth()->id(),
                    'receiver_id' => $appointment->doctor->user->id,
                    'user_role' => 'medico',
                    'title' => 'Nueva Cita Agendada',
                    'message' => "Nueva cita agendada para el " . $appointment->appointment_date . " a las " . $appointment->appointment_time,
                    'status' => 'pending'
                ]);
            }

            // Notify Patient
            if ($appointment->patient && $appointment->patient->user) {
                Notification::create([
                    'sender_id' => auth()->id(),
                    'receiver_id' => $appointment->patient->user->id,
                    'user_role' => 'paciente',
                    'title' => 'Nueva Cita Agendada',
                    'message' => "Tiene una cita programada con el Dr. " . ($appointment->doctor->user->name ?? 'Asignado') . " el " . $appointment->appointment_date . " a las " . $appointment->appointment_time,
                    'status' => 'pending'
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cita agendada exitosamente',
                'data' => $appointment
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('appointmentController@store: Error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error al agendar cita: ' . $e->getMessage()
            ], 500);
        }
    }

    public function indexView(Request $request)
    {
        $query = appointment::with(['patient.user', 'doctor.user'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'asc');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('temporary_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('date')) {
            $query->where('appointment_date', $request->date);
        }

        if ($request->filled('doctor_id')) {
            $query->whereHas('doctor', function ($q) use ($request) {
                $q->where('userId', $request->doctor_id);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $appointments = $query->paginate(5)->withQueryString();

        // Doctors for the filter
        $doctors = UserModel::where('typeUser_id', 2)
            ->where('status', 'active')
            ->get();

        // Calculate stats
        $today = Carbon::today()->toDateString();
        $stats = [
            'today' => appointment::whereDate('appointment_date', $today)->count(),
            'confirmed' => appointment::whereIn('status', ['Confirmada', 'completada'])->count(),
            'scheduled' => appointment::where('status', 'agendada')->count(),
            'cancelled' => appointment::where('status', 'cancelada')->count(),
        ];

        return view('RECEPCIONISTA.gestion-citas', compact('appointments', 'doctors', 'stats'));
    }

    public function searchPatients(Request $request)
    {
        $term = $request->input('query');
        
        if (!$term) {
            return response()->json([]);
        }

        // Search in appointments to find patients who have appointments
        // Or just search all patients? "buscar las citas por nombre de paciente"
        // It's better to suggest patients who actually have appointments or just any patient name.
        // Let's search distinct patient names from the appointments table (via relationships)
        // This might be heavy. Let's just search the User model for patients.
        // But the user wants to search *appointments*.
        // Let's search users who are patients matching the name.
        
        $patients = UserModel::where('typeUser_id', 3) // Patients
            ->where('name', 'like', "%{$term}%")
            ->limit(10)
            ->get(['name']);

        // Also consider temporary patients if any
        $tempPatients = patientUser::where('is_Temporary', true)
            ->where('temporary_name', 'like', "%{$term}%")
            ->limit(10)
            ->get(['temporary_name as name']);

        $results = $patients->concat($tempPatients)->pluck('name')->unique()->values();

        return response()->json($results);
    }

    public function reminders(Request $request)
    {
        $query = appointment::with(['patient.user', 'doctor.user'])
            ->orderBy('appointment_date', 'asc') // Upcoming first makes more sense for reminders
            ->orderBy('appointment_time', 'asc');

        // Simple filters if needed, or just paginate all
        // The view has filters, let's try to support at least date if passed
        if ($request->filled('date')) {
            $query->where('appointment_date', $request->date);
        }

        if ($request->filled('type')) {
            $query->where('reason', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $appointments = $query->paginate(5)->withQueryString();

        return view('RECEPCIONISTA.recordatorios', compact('appointments'));
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
            $query = appointment::with(['patient.user', 'doctor.user'])
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
            $appointment = appointment::findOrFail($id);
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

            $appointment = appointment::findOrFail($id);
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
