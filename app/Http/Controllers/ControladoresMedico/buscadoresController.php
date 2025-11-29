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
use App\Models\Medication;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\fileRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class buscadoresController extends Controller
{
    //
    //busqueda de nombre de paciente en area de archivos
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
    //autocompletado de diagnosticos agregar en un controlador de buscadores
    public function autocompletarDiagnostico(Request $request){
        $query = $request->get('query');

        $diagnostico = disease::where('name', 'LIKE', "%{$query}%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($diagnostico);
    }
    //autocompletado de alergias, agregar en un controlador de buscadores
    public function autocompletarAlergias(Request $request){
        $query = $request->get('query');

        $alergias = allergie::where('name', 'LIKE', "%{$query}%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($alergias);
    }
    //autocompletado de alergenos, agregar en un controlador de buscadores
    public function autocompletarAlergenos(Request $request){
        $query = $request->get('query');

        $alergenos = allergene::where('name', 'LIKE', "%{$query}%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($alergenos);
    }

    public function autocompletarMedicamentos(Request $request){
        $query = $request->get('query');

        $medications = Medication::where('name', 'LIKE', "%{$query}%")
            ->orWhere('category', 'LIKE', "%{$query}%")
            ->orWhere('presentation', 'LIKE', "%{$query}%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'category', 'presentation']);

        return response()->json($medications);
    }
}
