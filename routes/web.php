<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('LOGIN.login');
})->name('login');

//Rutas de paginas medico
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



//Desde aqui comienza la logica
//Login
Route::post('login', [LoginController::class, 'LoginRequest'])->name('login_Attempt');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


//Rutas a paginas paciente
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