<?php

use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProfileController;
use App\Models\Departamento;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/departamentos', function () {
//     return view('departamentos.index', [
//         'departamentos' => Departamento::all(),
//     ]);
// })->name('departamentos.index');

// Route::get('/departamentos/{departamento}', function (Departamento $departamento) {
//     return view('departamentos.view', [
//         'departamento' => $departamento,
//     ]);
// })->name('departamentos.view');

Route::resource('departamentos', DepartamentoController::class);
Route::resource('empleados', EmpleadoController::class);

require __DIR__.'/auth.php';
