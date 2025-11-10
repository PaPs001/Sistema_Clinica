<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\medical_Records;
use App\Models\UserModel;
use App\Models\patientUser;
use App\Models\vital_sign;
use App\Models\allergyRecord;
use App\Models\diseaseRecord;
use App\Models\consult_disease;
use App\Models\treatment_record;
use App\Models\appointment;
use App\Models\allergies_allergenes;
use App\Models\disease;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;

class mediController extends Controller
{
    //
    public function storeRecord(Request $request){
        // Validar los datos recibidos del formulario
        Log::info('Entro al metodo');
        Log::info('Datos recibidos del formulario:', $request->all());
        $validatedData = $request->validate([
            //Datos a insertar para usuario nuevo
            'nombre' => 'required|string|max:255',
            'fechaNacimiento' => 'required|date',
            'genero' => 'required|string|max:50',
            'direccion' => 'required|string|max:500',
            'telefono' => 'required|string|regex:/^[0-9+\-\s]+$/|max:20',
            'email' => 'required|email|max:255',

            // Alergias
            'alergias' => 'nullable|string|max:100',
            'alergeno' => 'nullable|string|max:100',
            'severidad_alergia' => 'nullable|string|in:Leve,Moderada,Grave',
            'status_alergia' => 'nullable|string|in:Activa,Inactiva',
            'sintomas_alergia' => 'nullable|string|max:500',
            'tratamiento_alergias' => 'nullable|string|max:500',
            'notas' => 'nullable|string|max:500',

            // Enfermedades crónicas
            'enfermedadesCronicas' => 'nullable|string|max:100',

            // Consulta médica
            'fechaConsulta' => 'required|date',
            'motivoConsulta' => 'required|string|max:500',
            'sintomas' => 'required|string|max:500',
            'exploracion' => 'required|string|max:500',
            'diagnostico' => 'required|string|max:500',
            'tratamiento' => 'required|string|max:500',
        ]);
Log::info('Antes del try');
        try{
            DB::beginTransaction();
            throw new \Exception('Error de prueba para ver si entra al catch');
            Log::info('Entrando en el bloque TRY');
            Log::info('Paso 1: buscando paciente');
            $patient = patientUser::where('temporary_name', $validatedData['nombre'])
                    ->where('is_Temporary', 1)
                    ->first();
            if($patient){
                $user = UserModel::create([
                    'name' => $validatedData['nombre'],
                    'birthdate' => $validatedData['fechaNacimiento'],
                    'phone' => $validatedData['telefono'],
                    'email' => $validatedData['email'],
                    'password' => '12345',
                    'address' => $validatedData['direccion'],
                    'status' => 'inactive',
                    'typeUser_id' => 3,
                    'genre' => $validatedData['genero']
                ]);
                $patient->update([
                    'is_Temporary' => 0,
                    'temporary_name' => null,
                    'temporary_phone' => null,
                    'userId' => $user->id,
                ]);
            }

            $appointment = appointment::where('patient_id', $patient->id)
                        ->whereDate('appointment_date', $validatedData['fechaConsulta'])
                        ->first();

            $record = medical_Records::create([
                'patient_id' => $patient->id,
                'creation_date' => $validatedData['fechaConsulta']
            ]);

            $allergie_allergene = allergies_allergenes::create([
                'allergie_id' => $validatedData['alergias'],
                'allergene_id' => $validatedData['alergeno'],
            ]);

            $allergie = allergyRecord::create([
                'id_record' => $record->id,
                'allergie_allergene_id' => $allergie_allergene->id,
                'severity' => $validatedData['severidad_alergia'],
                'status' => $validatedData['status_alergia'],
                'symptoms' => $validatedData['sintomas_alergia'],
                'treatments' => $validatedData['tratamiento_alergias'],
                'diagnosis_date' => $appointment->appointment_date,
                'notes' => $validatedData['notas'],
            ]);

            $chronic_disease = disease::firstOrCreate([
                'name' => $validatedData['enfermedadesCronicas'],
            ]);

            $chronic_disease_record = diseaseRecord::create([
                'id_record' => $record->id,
                'chronics_diseases_id' => $chronic_disease->id,
            ]);

            $consult_Disease = consult_disease::create([
                'id_medical_record' => $record->id,
                'appointment_id' => $appointment->id,
                'reason' => $validatedData['motivoConsulta'],
                'symptoms' => $validatedData['sintomas'],
                'findings' => $validatedData['exploracion'],
                'diagnosis' => $validatedData['diagnostico'],
                'treatment_diagnosis' => $validatedData['tratamiento']
            ]);
            
            DB::commit();
            Log::info('💾 Datos guardados correctamente en la base de datos');
            return redirect()->back()->with('success', 'Registro guardado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Error al guardar el registro: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
