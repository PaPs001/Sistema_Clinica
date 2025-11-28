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

class filtradoExpedientesController extends Controller
{
    //
    //filtrado de expediente por tipo de enfermedad
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
}
