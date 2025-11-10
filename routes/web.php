<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\mediController;


//Rutas login
Route::get('/', function () {
    return view('LOGIN.login');
})->name('loginDashboard');
Route::post('login', [LoginController::class, 'LoginRequest'])->name('login_Attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


//Rutas de paginas medico --------------------------------------------------------------
Route::get('/dashboard', function(){
    return view('MEDICO.dashboard-medico');
})->name('dashboardMedico');

Route::get('/registro-expediente', function(){
    return view('MEDICO.registro-expediente');
})->name('registro-expediente');

Route::get('/consulta-historial', function(){
    return view('MEDICO.consulta-historial');
})->name('consulta-historial');

Route::get('/subir-documentos', function(){
    return view('MEDICO.subir-documentos');
})->name('subir-documentos');

Route::get('/filtrar-expedientes', function(){
    return view('MEDICO.filtrar-expedientes');
})->name('filtrar-expedientes');

Route::get('/registro-alergias', function(){
    return view('MEDICO.registro-alergias');
})->name('registro-alergias');

Route::post('newRecord', [mediController::class, 'storeRecord'])->name('save_medical_record');
Route::get('/buscar-pacientes', [mediController::class, 'buscarPacientes'])->name('buscar.pacientes');


//Rutas a paginas paciente ---------------------------------------------------------------
Route::get('/dashboard-paciente', function(){
    return view('PACIENTE.dashboard-paciente');
})->name('dashboardPaciente');

Route::get('/historial_Paciente', function(){
    return view('PACIENTE.mi-historial');
})->name('historialPaciente');

Route::get('/citas-Paciente', function(){
    return view('PACIENTE.mis-citas');
})->name('citasPaciente');

Route::get('alergias-Paciente', function(){
    return view('PACIENTE.mis-alergias');
})->name('alergiasPaciente');

Route::get('/documentos-Paciente', function(){
    return view('PACIENTE.mis-documentos');
})->name('documentosPaciente');

Route::get('/perfil-Paciente', function(){
    return view('PACIENTE.perfil-paciente');
})->name('perfilPaciente');



//Rutas a paginas administrador --------------------------------------------------------------
Route::get('/dashboard-admin', function(){
    return view('ADMINISTRADOR.dashboard-admin');
})->name('dashboardAdmin');

Route::get('/auditoria', function(){
    return view('ADMINISTRADOR.auditoria');
})->name('auditoria');

Route::get('/configuracion', function(){
    return view('ADMINISTRADOR.configuracion');
})->name('configuracion');

Route::get('/control-accesos', function(){
    return view('ADMINISTRADOR.control-accesos');
})->name('controlAccesos');

Route::get('/gestion-roles', function(){
    return view('ADMINISTRADOR.gestion-roles');
})->name('gestionRoles');

Route::get('/respaldo-datos', function(){
    return view('ADMINISTRADOR.respaldo-datos');
})->name('respaldoDatos');


//Rutas a paginas recepcionista --------------------------------------------------------------
Route::get('/dasboard-recepcionista', function(){
    return view('RECEPCIONISTA.dashboard-recepcionista');
})->name('dashboardRecepcionista');

Route::get('/agenda', function(){
    return view('RECEPCIONISTA.agenda');
})->name('agenda');

Route::get('/gestion-citas', function(){
    return view('RECEPCIONISTA.gestion-citas');
})->name('gestionCitas');

Route::get('/pacientes-recepcionista', function(){
    return view('RECEPCIONISTA.pacientes-recepcion');
})->name('pacientesRecepcionista');

Route::get('/recordatorios', function(){
    return view('RECEPCIONISTA.recordatorios');
})->name('recordatorios');

Route::get('/registro-paciente', function(){
    return view('RECEPCIONISTA.registro-pacientes');
})->name('registroPaciente');


//Rutas a paginas enfermera --------------------------------------------------------------
Route::get('/dashboard-enfermera', function(){
    return view('ENFERMERA.dashboard-enfermera');
})->name('dashboardEnfermera');

Route::get('/citas-enfermera', function(){
    return view('ENFERMERA.citas-enfermera');
})->name('citasEnfermera');

Route::get('/medicamentos', function(){
    return view('ENFERMERA.medicamentos');
})->name('medicamentos');

Route::get('/pacientes-enfermera', function(){
    return view('ENFERMERA.pacientes-enfermera');
})->name('pacientesEnfermera');

Route::get('/reportes-enfermera', function(){
    return view('ENFERMERA.reportes-enfermera');
})->name('reportesEnfermera');

Route::get('/signos-vitales', function(){
    return view('ENFERMERA.signos-vitales');
})->name('signosVitales');

Route::get('/tratamientos', function(){
    return view('ENFERMERA.tratamientos');
})->name('tratamientos');