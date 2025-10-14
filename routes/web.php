<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::prefix('patients')->group(function () {
    Route::get('/', function () {
        return view('patients.index');
    })->name('patients.index');
});

Route::prefix('scans')->group(function () {
    Route::get('/', function () {
        return view('scans.index');
    })->name('scans.index');
});

Route::get('/calendar', function () {
    return view('calendar');
})->name('calendar');

Route::prefix('reports')->group(function () {
    Route::get('/', function () {
        return view('reports.index');
    })->name('reports.index');
});