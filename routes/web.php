<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HistoriaCliController;
use App\Http\Controllers\CitasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name(('welcome'));

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/historias', [HistoriaCliController::class, 'index'])->name('historias');
    Route::resource('historia', HistoriaCliController::class);
    Route::get('/citas', [CitasController::class, 'index'])->name('citas');
    Route::post('/cita/crear', [CitasController::class, 'store']);
    Route::post('/cita/editar/{id}', [CitasController::class, 'edit']);
    Route::post('/cita/reservar/{id}', [CitasController::class, 'reservar']);
    Route::post('/cita/cancelar/{id}', [CitasController::class, 'cancelar']);
    Route::get('/citas/mostrar', [CitasController::class, 'show'])->name('mostrarCita');
    Route::post('/guardar-fecha', [CitasController::class, 'guardarDatos']);
});
