<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; // Import Log
use Carbon\Carbon;

class PatientController extends Controller
{
    public function store(Request $request)
    {
        Log::info('PatientController@store: Recibiendo solicitud', $request->all()); // DEBUG LOG

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:general_users,email',
            'phone' => 'required|string|max:20',
            'dob' => 'required|date',
            'gender' => 'required|in:M,F,O,N',
            'id_number' => 'required|string|max:50', // Mapped from 'id' in frontend
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
            'blood_type' => 'nullable|string|max:5',
            'allergies' => 'nullable|string',
            'medications' => 'nullable|string',
            'conditions' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            Log::error('PatientController@store: Error de validación', $validator->errors()->toArray()); // DEBUG LOG
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $patientId = DB::table('general_users')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'birthdate' => $request->dob,
                'genre' => $this->mapGender($request->gender),
                'address' => $request->address . ', ' . $request->city . ', ' . $request->state . ' ' . $request->zip,
                'password' => Hash::make($request->phone), // Default password is phone number
                'typeUser_id' => 3, // Paciente
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Note: We are not using a separate patients table as per instructions to only use general_users for now
            // If there were a patients table, we would insert here using $patientId

            DB::commit();

            Log::info('PatientController@store: Paciente registrado con ID: ' . $patientId); // DEBUG LOG

            return response()->json([
                'success' => true,
                'message' => 'Paciente registrado exitosamente',
                'data' => ['id' => $patientId]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('PatientController@store: Excepción al registrar: ' . $e->getMessage()); // DEBUG LOG
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar paciente: ' . $e->getMessage()
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
