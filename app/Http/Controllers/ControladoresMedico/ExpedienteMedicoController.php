<?php

namespace App\Http\Controllers\ControladoresMedico;

use App\Http\Controllers\Controller; 
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
use App\Models\documentType;
use App\Models\allergie;
use App\Models\allergene;
use App\Models\MedicPatient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\fileRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;

class ExpedienteMedicoController extends Controller
{
    //
    public function storeRecord(Request $request){
        Log::info('Entro al metodo');
    Log::info('Datos recibidos del formulario:', $request->all());
    
    try{
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'fechaNacimiento' => 'required|date',
            'genero' => 'required|string|max:50',
            'direccion' => 'required|string|max:500',
            'telefono' => 'required|string|regex:/^[0-9+\-\s]+$/|max:20',
            'email' => 'required|email|max:255',

            'alergias' => 'nullable|array',
            'alergias.*' => 'nullable|string|max:100',
            'alergenos' => 'nullable|array',
            'alergenos.*' => 'nullable|string|max:100',
            'severidad_alergia' => 'nullable|array',
            'severidad_alergia.*' => 'nullable|string|in:Leve,Moderada,Grave',
            'status_alergia' => 'nullable|array',
            'status_alergia.*' => 'nullable|string|in:Activa,Inactiva',
            'sintomas_alergia' => 'nullable|array',
            'sintomas_alergia.*' => 'nullable|string',
            'tratamiento_alergias' => 'nullable|array',
            'tratamiento_alergias.*' => 'nullable|string',
            'notas' => 'nullable|array',
            'notas.*' => 'nullable|string',
            'enfermedades-cronicas' => 'nullable|array',
            'enfermedades-cronicas.*' => 'nullable|string|max:100',
            
            'fechaConsulta' => 'required|date',
            'motivoConsulta' => 'required|string|max:1000',
            'sintomas' => 'required|string',
            'exploracion' => 'required|string',
            'diagnostico_id' => 'required|integer',
            'tratamiento' => 'required|string',
        ]);
        Log::info('Validación completada exitosamente.');
    }
    catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Error de validación:', $e->errors());
        throw $e;
    }

    Log::info('Siguió después de la validación');
    
    try{
        DB::beginTransaction();
        Log::info('Entrando en el bloque TRY');
        Log::info('Paso 1: buscando paciente');
        $patient = null;
        
        if ($request->has('paciente_id') && $request->paciente_id) {
            $patient = patientUser::find($request->paciente_id);
            Log::info('Buscando paciente por ID:', ['id' => $request->paciente_id, 'encontrado' => !is_null($patient)]);
        }
        
        if (!$patient) {
            $patient = patientUser::where('temporary_name', $validatedData['nombre'])
                    ->where('is_Temporary', 1)
                    ->first();
            Log::info('Buscando paciente temporal por nombre:', ['nombre' => $validatedData['nombre'], 'encontrado' => !is_null($patient)]);
        }
        
        if (!$patient) {
            Log::info('No se encontró paciente existente, creando nuevo usuario y paciente');
            
            $userCode = 'PAT' . rand(1000, 9999);
            $user = UserModel::create([
                'name' => $validatedData['nombre'],
                'birthdate' => $validatedData['fechaNacimiento'],
                'phone' => $validatedData['telefono'],
                'email' => $validatedData['email'],
                'password' => $userCode,
                'address' => $validatedData['direccion'],
                'status' => 'inactive',
                'typeUser_id' => 3,
                'genre' => $validatedData['genero']
            ]);
            $patient = patientUser::create([
                'userId' => $user->id,
                'is_Temporary' => 0,
                'temporary_name' => null,
                'temporary_phone' => null,
                'userCode' => $userCode,
            ]);
            
            Log::info('Nuevo paciente creado:', ['patient_id' => $patient->id]);
        }
        elseif ($patient && $patient->is_Temporary == 1) {
            Log::info('Paciente temporal encontrado, actualizando a permanente');
            
            $userCode = 'PAT' . rand(1000, 9999);
            $user = UserModel::create([
                'name' => $validatedData['nombre'],
                'birthdate' => $validatedData['fechaNacimiento'],
                'phone' => $validatedData['telefono'],
                'email' => $validatedData['email'],
                'password' => $userCode,
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
                'userCode' => $userCode,
            ]);
            
            Log::info('Paciente temporal actualizado:', ['patient_id' => $patient->id]);
        }
        
        if (!$patient) {
            throw new \Exception('No se pudo encontrar o crear el paciente');
        }
        $doctor = Auth::user()->medic;
        $doctorId = $doctor ? $doctor->id : null;
        Log::info('Doctor ID obtenido: ' . $doctorId);
        $exists = MedicPatient::where('patient_id', $patient->id)
                ->where('medic_id', $doctorId)
                ->exists();

            if (!$exists) {
                MedicPatient::insert([
                    'patient_id' => $patient->id,
                    'medic_id' => $doctorId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            Log::info('Relación médico-paciente verificada/creada', [
                'patient_id' => $patient->id,
                'medic_id' => $doctorId
            ]);
        
        Log::info('Paciente obtenido:', ['patient_id' => $patient->id]);
        
        Log::info('Paso 2: buscando appointment');
        
        $fecha = \Carbon\Carbon::parse($validatedData['fechaConsulta']);
        $appointment = appointment::where('patient_id', $patient->id)
            ->where('doctor_id', $doctorId)
            ->where('status', 'agendada')
            ->whereDate('appointment_date', $fecha->toDateString())
            ->whereTime('appointment_time', $fecha->toTimeString())
            ->first();
            
            //}
            if($patient->userId == null){
                Log::info('paso 3: Cambiando valores del medical record');
                $record = medical_Records::create([
                    'patient_id' => $patient->id,
                    'creation_date' => $validatedData['fechaConsulta']
                ]);
            }else{
                Log::info('Paso 3: Paciente existente, buscando expediente médico previo');
                $record = medical_Records::where('patient_id', $patient->id)->first();

                if(!$record){
                    Log::warning('No se encontró expediente previo, creando uno nuevo como respaldo');
                    $record = medical_Records::create([
                        'patient_id' => $patient->id,
                        'creation_date' => $validatedData['fechaConsulta']
                    ]);
                } else {
                    Log::info('Expediente existente encontrado: ID '.$record->id);
                }
            }
            if(!empty($validatedData['alergias']) && !empty($validatedData['alergenos'])){
                DB::transaction(function () use ($validatedData, $record, $appointment) {
                    $requiredKeys = [
                        'alergenos',
                        'severidad_alergia',
                        'status_alergia',
                        'sintomas_alergia',
                        'tratamiento_alergias',
                        'notas',
                        'enfermedades-cronicas',
                    ];
                    Log::info('paso 4: Agregando alergenos en caso de que existan');
                    for ($i = 0; $i < count($validatedData['alergias']); $i++) {
                        foreach ($requiredKeys as $key) {
                            if (!isset($validatedData[$key][$i])) {
                                throw new \Exception("Faltan datos en $key[$i]");
                            }
                        }
                        $allergie = allergie::firstOrCreate([
                            'name' => $validatedData['alergias'][$i],
                        ]);

                        $allergen = allergene::firstOrCreate([
                            'name' => $validatedData['alergenos'][$i],
                        ]);

                        $pivot = allergies_allergenes::create([
                            'allergie_id' => $allergie->id,
                            'allergene_id' => $allergen->id,
                        ]);

                        allergyRecord::create([
                            'id_record'              => $record->id,
                            'allergie_allergene_id'  => $pivot->id,
                            'severity'               => $validatedData['severidad_alergia'][$i],
                            'status'                 => $validatedData['status_alergia'][$i],
                            'symptoms'               => $validatedData['sintomas_alergia'][$i],
                            'treatments'             => $validatedData['tratamiento_alergias'][$i],
                            'diagnosis_date'         => $appointment->appointment_date,
                            'notes'                  => $validatedData['notas'][$i],
                        ]);

                        $diseaseName = $validatedData['enfermedades-cronicas'][$i];

                        if (!empty($diseaseName)) {
                            $disease = disease::firstOrCreate(['name' => $diseaseName]);

                            diseaseRecord::create([
                                'id_record'            => $record->id,
                                'chronics_diseases_id' => $disease->id,
                            ]);
                        }
                    }
                });
            }
        
            Log::info('paso 8: agregando la informacion de consulta');
            $consult_Disease = consult_disease::create([
                'id_medical_record' => $record->id,
                'appointment_id' => $appointment->id,
                'reason' => $validatedData['motivoConsulta'],
                'symptoms' => $validatedData['sintomas'],
                'findings' => $validatedData['exploracion'],
                'diagnosis_id' => $validatedData['diagnostico_id'],
                'treatment_diagnosis' => $validatedData['tratamiento']
            ]);
            
            DB::commit();
            $emailToSend = $patient->user->email;
            $temporalPassword = $patient->userCode;
            $name = $patient->user->name;
            $fecha = Carbon::now()->toDateString();
            $status = $patient->user->status;
            if($status == 'inactive'){
                Mail::to($emailToSend)
                    ->send(new NotificationMail(
                        $temporalPassword,
                        $name,
                        $fecha,
                    ));
            }
            Log::info('Enviando correo a: ' . $emailToSend);
            Log::info('Datos guardados correctamente en la base de datos');
            return redirect()->back()->with('success', 'Registro guardado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al guardar el registro: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }









    //Buscar pacientes en agregado de expedientes
    public function buscarPacientes(Request $request){
        $query = $request->get('query');
        $doctor = Auth::user()->medic;
        $doctorId = $doctor ? $doctor->id : null;
        //se obtiene el usuario del paciente teniendo en cuenta de si es temporal o no y lo busca dependiendo de si el medico que lo registra es el que
        //va a dar la consulta
        $pacientesTemporales = patientUser::where('is_temporary', 1)
        ->where('temporary_name', 'LIKE', "%{$query}%")
        ->whereHas('appointments', function ($q) use ($doctorId) {
            $q->where('doctor_id', $doctorId);
        })
        ->limit(10)
        ->get(['id','temporary_name','temporary_phone'])
        ->map(function ($p) use ($doctorId) {

            $cita = appointment::where('patient_id', $p->id)
                ->where('doctor_id', $doctorId)
                ->where('status', 'agendada')
                ->latest()
                ->first();

            if ($cita) {
                $signos = vital_sign::where('patient_id', $p->id)
                    ->where('register_date', $cita->id)
                    ->first();
            } else {
                $signos = null;
            }

            return [
                'id' => $p->id,
                'userId' => $p->userId,
                'nombre' => $p->temporary_name,
                'telefono' => $p->temporary_phone,
                'signos_vitales' => $signos ? [
                    'presion_arterial' => $signos->blood_pressure,
                    'frecuencia_cardiaca' => $signos->heart_rate,
                    'temperatura' => $signos->temperature,
                    'peso' => $signos->weight,
                    'estatura' => $signos->height,
                    'cita' => $cita ? [
                        'id' => $cita->id,
                        'fecha' => $cita->appointment_date,
                        'hora' => $cita->appointment_time,
                        'motivo' => $cita->reason ?? '',
                    ] : null
                ] : null,
            ];
        });
    
     $pacientesRegistrados = patientUser::whereNotNull('userId')
        ->whereHas('user', function ($q) use ($query) {
            $q->where('name','LIKE',"%{$query}%");
        })
        ->whereHas('appointments', function ($q) use ($doctorId) {
            $q->where('doctor_id', $doctorId);
        })
        ->with('user:id,name,phone,birthdate,address,genre,email')
        ->limit(10)
        ->get(['id','userId'])
        ->map(function ($p) use ($doctorId) {
            $cita = appointment::where('patient_id', $p->id)
                ->where('doctor_id', $doctorId)
                ->where('status', 'agendada')
                ->latest()
                ->first();

            if ($cita) {
                $signos = vital_sign::where('patient_id', $p->id)
                    ->where('register_date', $cita->id)
                    ->first();
            } else {
                $signos = null;
            }


            return [
                'id' => $p->id,
                'userId' => $p->userId,
                'nombre' => $p->user->name,
                'telefono' => $p->user->phone,
                'genero' => $p->user->genre,
                'fechaNacimiento' => $p->user->birthdate,
                'email' => $p->user->email,
                'direccion' => $p->user->address,
                'signos_vitales' => $signos ? [
                    'presion_arterial' => $signos->blood_pressure,
                    'frecuencia_cardiaca' => $signos->heart_rate,
                    'temperatura' => $signos->temperature,
                    'peso' => $signos->weight,
                    'estatura' => $signos->height,
                    'cita' => $cita ? [
                        'id' => $cita->id,
                        'fecha' => $cita->appointment_date,
                        'hora' => $cita->appointment_time,
                        'motivo' => $cita->reason ?? '',
                    ] : null
                ] : null,
            ];
        });
    
    $resultados = $pacientesTemporales->concat($pacientesRegistrados);
    
    return response()->json($resultados);
    Log::info($resultados);
    }
}


