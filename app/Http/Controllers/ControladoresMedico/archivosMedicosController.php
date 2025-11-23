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

class archivosMedicosController extends Controller
{
    //
     //Solo obtiene los tipos de documentos en pagina para subir archivos
    public function iniciarPaginaUploadFiles(){
        $tiposDocumentos = documentType::select('id', 'name')
            ->get();
        return view('MEDICO.subir-documentos', compact('tiposDocumentos'));
    }
    //Funcion para subir archivos
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

    
}
