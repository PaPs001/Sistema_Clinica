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

class historialMedicoController extends Controller
{
    //
     
    //Listado de pacientes para consulta su historial
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
    //Obtener las conexiones de los modelos para lograr obtener la informacion necesaria del historial medico
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
}
