<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\GeneralController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function(){
    return view('MEDICO.dashboard-medico');
})->name('dashboard');

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
