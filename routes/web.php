<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CsvController;

Route::get('/', function () {return view('index');})->name('index');

Route::post('/archivo', [CsvController::class, 'leer'])->name('archivo.leer');
Route::get('/archivo', [CsvController::class, 'mostrar'])->name('archivo.mostrar');
Route::post('/eliminar', [CsvController::class, 'eliminarCsv'])->name('eliminar.csv');

