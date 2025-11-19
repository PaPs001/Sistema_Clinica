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
use App\Models\documentType;
use App\Models\allergie;
use App\Models\allergene;
use App\Models\MedicPatient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\fileRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class mediController extends Controller
{
    //
    public function GetData(){
        $generos = UserModel->genre;
        return view('LOGIN.login', compact('genre'));
    }

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
            'sintomas_alergia.*' => 'nullable|string|max:500',
            'tratamiento_alergias' => 'nullable|array',
            'tratamiento_alergias.*' => 'nullable|string|max:500',
            'notas' => 'nullable|array',
            'notas.*' => 'nullable|string|max:500',
            'enfermedades-cronicas' => 'nullable|array',
            'enfermedades-cronicas.*' => 'nullable|string|max:100',
            
            'fechaConsulta' => 'required|date',
            'motivoConsulta' => 'required|string|max:500',
            'sintomas' => 'required|string|max:500',
            'exploracion' => 'required|string|max:500',
            'diagnostico_id' => 'required|integer',
            'tratamiento' => 'required|string|max:500',
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
            $userCode = 'PAT' . rand(1000, 9999);
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
            Log::info('Datos guardados correctamente en la base de datos');
            return redirect()->back()->with('success', 'Registro guardado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al guardar el registro: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function buscarPacientes(Request $request){
        $query = $request->get('query');
        $doctor = Auth::user()->medic;
        $doctorId = $doctor ? $doctor->id : null;

        $pacientesTemporales = patientUser::where('is_temporary', 1)
            ->where('temporary_name', 'LIKE', "%{$query}%")
            ->whereHas('appointments', function ($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId);
            })
            ->limit(10)
            ->get(['id', 'temporary_name', 'temporary_phone']);

        $pacientesRegistrados = patientUser::whereNotNull('userId')
            ->whereHas('user', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->whereHas('appointments', function ($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId);
            })
            ->with('user:id,name,phone,birthdate,address,genre,email')
            ->limit(10)
            ->get(['id', 'userId']);

        $pacientesTemporales = $pacientesTemporales->map(function ($p) use ($doctorId) {
            $signosVitales = vital_sign::with('appointment')
                ->where('patient_id', $p->id)
                ->latest()
                ->first();

            $citaDelMedico = null;

            $citaDelMedico = appointment::where('patient_id', $p->id)
                ->where('doctor_id', $doctorId)
                ->where('status', 'agendada')
                ->latest()
                ->first();

                return [
                    'id' => $p->id,
                    'userId' => $p->userId,
                    'nombre' => $p->temporary_name,
                    'telefono' => $p->temporary_phone,
                    'signos_vitales' => $signosVitales ? [
                        'presion_arterial' => $signosVitales->blood_pressure,
                        'frecuencia_cardiaca' => $signosVitales->heart_rate,
                        'temperatura' => $signosVitales->temperature,
                        'peso' => $signosVitales->weight,
                        'estatura' => $signosVitales->height,
                        'cita' => $citaDelMedico ? [
                            'id' => $citaDelMedico->id,
                            'fecha' => $citaDelMedico->appointment_date,
                            'hora' => $citaDelMedico->appointment_time,
                            'motivo' => $citaDelMedico->reason ?? '',
                ] : null
            ] : null,
        ];
    });

    $pacientesRegistrados = $pacientesRegistrados->map(function ($p) {
        $signosVitales = vital_sign::with('appointment')
            ->where('patient_id', $p->id)
            ->latest()
            ->first();

        return [
            'id' => $p->id,
            'userId' => $p->userId,
            'nombre' => $p->user->name,
            'telefono' => $p->user->phone,
            'genero' => $p->user->genre,
            'fechaNacimiento' => $p->user->birthdate,
            'email' => $p->user->email,
            'direccion' => $p->user->address,
            'signos_vitales' => $signosVitales ? [
                'presion_arterial' => $signosVitales->blood_pressure,
                'frecuencia_cardiaca' => $signosVitales->heart_rate,
                'temperatura' => $signosVitales->temperature,
                'peso' => $signosVitales->weight,
                'estatura' => $signosVitales->height,
                'cita' => $signosVitales->appointment ? [
                    'id' => $signosVitales->appointment->id,
                    'fecha' => $signosVitales->appointment->appointment_date,
                    'hora' => $signosVitales->appointment->appointment_time,
                    'motivo' => $signosVitales->appointment->reason ?? '',
                ] : null
            ] : null,
        ];
    });

    $resultados = $pacientesTemporales->concat($pacientesRegistrados);

    return response()->json($resultados);
    Log::info($resultados);
}
    
    public function listarPacientes(Request $request)
    {
        $doctor = Auth::user()->medic;
        $doctorId = $doctor ? $doctor->id : null;
        $search = $request->input('buscar');
        
        $relacion  =    
        $patientUser = patientUser::with('user')
            ->whereHas('medicPatient', function ($query) use ($doctorId){
                $query->where('medic_id', $doctorId);
            })
            ->whereHas('user', function ($query) use ($search) {
                if (!empty($search)) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                }
            })
            ->paginate(5)
            ->withQueryString(); 

        return view('MEDICO.consulta-historial', compact('patientUser'));
    }

    public function getHistorial($id){
        $patientUser = patientUser::with([
            'vitalSigns.appointment',
            'medicalRecords.allergies.allergieAllergene.allergie',
            'medicalRecords.allergies.allergieAllergene.allergene',
            'appointments',
            'medicalRecords.consultDiseases.disease',
            'medicalRecords.diseaseRecords.disease',
            'user',
            'medicalRecords.files.documentType',
        ])->findOrFail($id);
            return response()->json($patientUser);
        //return view('MEDICO.consulta-historial', compact('patientUser'));
    }

    public function buscarPacienteArchivos(Request $request){
        $query = $request->get('query');
        $doctor = Auth::user()->medic;
        $doctorId = $doctor ? $doctor->id : null;
        
        $pacientesArchivos = patientUser::whereNotNull('userId')
        ->whereHas('medicPatient', function ($query) use ($doctorId){
                $query->where('medic_id', $doctorId);
            })
        ->whereHas('user', function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%");
        })
        ->with('user:id,name')
        ->limit(10)
        ->get(['id', 'userId']);

        return response()->json($pacientesArchivos);
    }

    public function autocompletarDiagnostico(Request $request){
        $query = $request->get('query');

        $diagnostico = disease::where('name', 'LIKE', "%{$query}%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($diagnostico);
    }

    public function autocompletarAlergias(Request $request){
        $query = $request->get('query');

        $alergias = allergie::where('name', 'LIKE', "%{$query}%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($alergias);
    }

    public function autocompletarAlergenos(Request $request){
        $query = $request->get('query');

        $alergenos = allergene::where('name', 'LIKE', "%{$query}%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($alergenos);
    }

    public function iniciarPaginaUploadFiles(){
        $tiposDocumentos = documentType::select('id', 'name')
            ->get();
        return view('MEDICO.subir-documentos', compact('tiposDocumentos'));
    }

    public function subirArchivos(Request $request){
        Log::info('Datos recibidos del formulario:', $request->all());
        try{
            $request->validate([
            'archivo' => 'required|array|max:20',
            'archivo.*' => 'required|file|mimes:pdf,jpg,png|max:20240',
            'nombre' => 'required|string|max:256',
            'tipoDocumento' => 'required|integer',
            'descripcionDoc' => 'required|string',
            'paciente_id' => 'required|integer|max:200',
            ]);
        Log::info('Validación completada exitosamente.');
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación:', $e->errors());
            throw $e;
        }

        try{
            DB::beginTransaction();
            foreach($request['archivo'] as $archivo){
                $file = $archivo;
                $diaSubida = Carbon::now()->toDateTimeString();
                $ruta = $file->store('documentos', 'public');
                $nombreArchivo = $file->getClientOriginalName();
                $pesoBytes = $file->getSize();
                if($pesoBytes < 1048576){
                    $peso = round($pesoBytes / 1024, 2);
                }else{
                    $peso = round($pesoBytes / 1048576, 2);
                }
                $extension = $file->getClientOriginalExtension();
                
                Log::info('Obteniendo dato del usuario: ' . $request->paciente_id);
                $paciente = patientUser::where('id', $request->paciente_id)->firstOrFail();
                
                Log::info('Buscando registro médico para paciente ID: ' . $paciente->id);
                $record = medical_records::where('patient_id', $paciente->id)->first();
                Log::info('Resultado de búsqueda record:', ['record' => $record]);
                
                $filesInformation = fileRecord::create([
                    'id_record' => $record->id,
                    'file_name' => $nombreArchivo,
                    'route' => $ruta,
                    'format' => $extension,
                    'file_size' => $peso,
                    'description' => $request->descripcionDoc,
                    'document_type_id' => $request->tipoDocumento,
                    'upload_date' => $diaSubida,
                ]);
    
                Log::info('Informacion del archivo a subir: ' . $filesInformation);
    
                DB::commit();
                Log::info('Datos guardados correctamente en la base de datos');
                return redirect()->back()->with('success', 'Archivo subido correctamente');
            }
        }catch(\Exception $e){
            DB::rollBack();
            Log::error('Error al guardar el registro: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }    
    }

    public function filtradoExpedientes(Request $request){
        $texto = $request->input('texto');
        $doctor = Auth::user()->medic;
        $doctorId = $doctor ? $doctor->id : null;
        $expedientes = medical_records::whereHas('patientUser.medicAll', function($q) use ($doctorId){
            $q->where('medic_id', $doctorId);
        })
            ->whereHas('consultDiseases.disease', function($q) use ($texto) {
                if(!empty($texto)){
                    $q->where('name', 'LIKE', "%$texto%");
                }
        })
        ->with(['patientUser.user', 'consultDiseases.disease'])
        ->paginate(4);

        return response()->json($expedientes);
    }

    public function agregarAlergia(Request $request){
        $query = $request->get('query');
        Log::info('REQUEST COMPLETO:', $request->all());

        try {

            Log::info('Validando estructura general del request...');

            $request->validate([
                'paciente_id' => 'required',
                'nombre' => 'required|max:100',
                'alergias' => 'required|array',
                'alergenos' => 'required|array',
                'severidad_alergia' => 'required|array',
                'status_alergia' => 'required|array',
                'sintomas_alergia' => 'required|array',
                'tratamiento_alergias' => 'required|array',
                'notas' => 'required|array',
                'enfermedades-cronicas_id' => 'required|array',
                'notas_enfermedades' => 'required|array',
            ]);

            Log::info('Estructura validada correctamente.');

            $record = medical_Records::where('patient_id', $request->paciente_id)->first();

            if (!$record) {
                Log::error("No se encontró record médico del paciente con ID: {$request->paciente_id}");
                return back()->withErrors(['error' => 'No se encontró el expediente médico del paciente']);
            }

            Log::info("Record médico encontrado:", $record->toArray());

            foreach ($request['alergias'] as $i => $alergiaNombre) {
                Log::info("Datos en índice $i:", [
                    'alergia' => $request['alergias'][$i] ?? null,
                    'alergeno' => $request['alergenos'][$i] ?? null,
                    'severidad' => $request['severidad_alergia'][$i] ?? null,
                    'status' => $request['status_alergia'][$i] ?? null,
                    'sintomas' => $request['sintomas_alergia'][$i] ?? null,
                    'tratamientos' => $request['tratamiento_alergias'][$i] ?? null,
                    'notas' => $request['notas'][$i] ?? null,
                    'cronica' => $request['enfermedades-cronicas'][$i] ?? null,
                    'notas_cronica' => $request['notas_enfermedades'][$i] ?? null,
                ]);

                Log::info("Validando datos del índice $i...");

                $validatedData = $request->validate([
                    "alergias.$i" => 'required|max:100',
                    "alergenos.$i" => 'required|max:100',
                    "severidad_alergia.$i" => 'required|in:Leve,Moderada,Grave',
                    "status_alergia.$i" => 'required|in:Activa,Inactiva',
                    "sintomas_alergia.$i" => 'required|max:500',
                    "tratamiento_alergias.$i" => 'required|max:500',
                    "notas.$i" => 'required|max:500',
                    "enfermedades-cronicas_id.$i" => 'required',
                    "notas_enfermedades.$i" => 'required|max:500',
                ]);

                Log::info("Validación del índice $i completada.");


                $allergie = allergie::firstOrCreate([
                    'name' => $request['alergias'][$i]
                ]);
                Log::info("Alergia creada/obtenida:", $allergie->toArray());


                $allergen = allergene::firstOrCreate([
                    'name' => $request['alergenos'][$i]
                ]);
                Log::info("Alergeno creado/obtenido:", $allergen->toArray());


                $allergie_allergene = allergies_allergenes::firstOrCreate([
                    'allergie_id' => $allergie->id,
                    'allergene_id' => $allergen->id,
                ]);
                Log::info("Relación alergia-alergeno creada:", $allergie_allergene->toArray());

                $diaSubida = Carbon::now()->toDateTimeString();

                $allergieRecord = allergyRecord::create([
                    'id_record' => $record->id,
                    'allergie_allergene_id' => $allergie_allergene->id,
                    'severity' => $request['severidad_alergia'][$i],
                    'status' => $request['status_alergia'][$i],
                    'symptoms' => $request['sintomas_alergia'][$i],
                    'treatments' => $request['tratamiento_alergias'][$i],
                    'diagnosis_date' => $diaSubida,
                    'notes' => $request['notas'][$i],
                ]);

                Log::info("Registro de alergia creado:", $allergieRecord->toArray());


                $chronic = diseaseRecord::create([
                    'id_record' => $record->id,
                    'chronics_diseases_id' => $request['enfermedades-cronicas_id'][$i],
                    'notes' => $request['notas_enfermedades'][$i],
                ]);

                Log::info("Registro de enfermedad crónica creado:", $chronic->toArray());

                Log::info("===== FIN ITERACIÓN $i =====");
            }

            Log::info('===== FIN CORRECTO storeAlergias =====');

            return redirect()->back()->with('success', 'Registro guardado correctamente.');

        } catch (\Exception $e) {

            Log::error("ERROR EN storeAlergias: " . $e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->withErrors(['error' => 'Ocurrió un error al guardar los datos.']);
        }
    }
}
