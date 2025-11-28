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

class antecedentesMedicosController extends Controller
{
    //
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

            }
            return redirect()->back()->with('success', 'Registro guardado correctamente.');

        } catch (\Exception $e) {

            Log::error("ERROR EN storeAlergias: " . $e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->withErrors(['error' => 'Ocurrió un error al guardar los datos.']);
        }
    }
}
