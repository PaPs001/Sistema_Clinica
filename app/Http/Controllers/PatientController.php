<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; // Import Log
use Carbon\Carbon;

use App\Models\UserModel;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        // Solo pacientes definitivos (no temporales). Los temporales viven en patient_users.
        $query = UserModel::where('typeUser_id', 3);

        // Search by name or phone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            switch ($request->date) {
                case 'hoy':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'semana':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'mes':
                    $query->whereMonth('created_at', Carbon::now()->month)
                          ->whereYear('created_at', Carbon::now()->year);
                    break;
                case 'anio':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'nombre_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'nombre_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'fecha_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'fecha_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $patients = $query->paginate(5)->withQueryString();

        // Calculate stats (keep these global or filtered? Usually global stats are preferred for the dashboard feel, but let's keep them global for now as per previous request)
        $totalPatients = UserModel::where('typeUser_id', 3)->count();
        $newPatientsWeek = UserModel::where('typeUser_id', 3)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $newPatientsToday = UserModel::where('typeUser_id', 3)->whereDate('created_at', Carbon::today())->count();

        return view('RECEPCIONISTA.pacientes-recepcion', compact('patients', 'totalPatients', 'newPatientsWeek', 'newPatientsToday'));
    }

    public function create()
    {
        // Fetch recent patients (limit 3 for the cards)
        $recentPatients = UserModel::where('typeUser_id', 3) // 3 is likely patient role
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Calculate stats
        $stats = [
            'today' => UserModel::where('typeUser_id', 3)->whereDate('created_at', Carbon::today())->count(),
            'week' => UserModel::where('typeUser_id', 3)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
            'month' => UserModel::where('typeUser_id', 3)->whereMonth('created_at', Carbon::now()->month)->count(),
            'total' => UserModel::where('typeUser_id', 3)->count(),
        ];

        return view('RECEPCIONISTA.registro-pacientes', compact('recentPatients', 'stats'));
    }

    public function store(Request $request)
    {
        Log::info('PatientController@store: Recibiendo solicitud', $request->all()); // DEBUG LOG

        $isQuickRegistration = $request->input('is_quick_registration', false);

        if ($isQuickRegistration) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'dob' => 'required|date',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255|unique:general_users,email',
                'phone' => 'required|string|max:20',
                'dob' => 'required|date',
                'gender' => 'required|in:M,F,O,N',
                'id_number' => 'required|string|max:50',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'zip' => 'required|string|max:20',
            ]);
        }

        if ($validator->fails()) {
            Log::error('PatientController@store: Error de validación', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Prepare data for insertion
            $data = [
                'name' => $request->name,
                'phone' => $request->phone,
                'birthdate' => $request->dob,
                'password' => Hash::make($request->phone),
                'typeUser_id' => 3, // Paciente
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            if ($isQuickRegistration) {
                // Fill defaults for quick registration
                $data['email'] = 'sin_email_' . time() . '@sistema.local'; // Dummy unique email
                $data['address'] = 'Sin dirección registrada';
                $data['genre'] = 'hombre'; // Default, user can update later
                // Note: 'id_number' is not in general_users table based on migration I saw earlier?
                // Wait, I saw the migration:
                // $table->string('name');
                // $table->date('birthdate');
                // $table->string('phone');
                // $table->string('email');
                // $table->string('password');
                // $table->string('address');
                // $table->enum('genre', ['hombre', 'mujer']);
                // $table->enum('status', ['active', 'inactive'])->default('inactive');
                // $table->unsignedBigInteger('typeUser_id')->nullable();
                
                // There is NO 'id_number' column in general_users! 
                // The previous validation had 'id_number' => 'required', but it wasn't being inserted into general_users.
                // It might have been for a separate 'patients' table that doesn't exist yet or I missed it.
                // The previous insert code was:
                // 'address' => $request->address . ', ' . $request->city . ...
                
            } else {
                $data['email'] = $request->email;
                $data['address'] = $request->address . ', ' . $request->city . ', ' . $request->state . ' ' . $request->zip;
                $data['genre'] = $this->mapGender($request->gender);
            }

            $patientId = DB::table('general_users')->insertGetId($data);

            DB::commit();

            Log::info('PatientController@store: Paciente registrado con ID: ' . $patientId);

            return response()->json([
                'success' => true,
                'message' => 'Paciente registrado exitosamente',
                'data' => ['id' => $patientId]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('PatientController@store: Excepción al registrar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar paciente: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::table('general_users')
                ->where('id', $id)
                ->update([
                    'status' => $request->status,
                    'updated_at' => Carbon::now(),
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Estado del paciente actualizado exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('PatientController@update: Error al actualizar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar estado'
            ], 500);
        }
    }

    private function mapGender($code)
    {
        return match ($code) {
            'M' => 'hombre',
            'F' => 'mujer',
            default => 'hombre', // Default fallback or handle 'O'/'N' as needed based on enum
        };
    }
}
