<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArchivoControlador;

Route::get('/', function () {return view('welcome');});

Route::post('/archivo', [ArchivoControlador::class, 'leer'])->name('archivo.leer');
Route::get('/archivo', [ArchivoControlador::class, 'paginacion'])->name('archivo.paginacion');
