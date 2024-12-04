<?php

use App\Generico\Carrito;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ProfileController;
use App\Models\Articulo;
use App\Models\Factura;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


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
Route::resource('articulos', ArticuloController::class);
Route::resource('facturas', FacturaController::class);


Route::get('/carrito/meter/{articulo}', function (Articulo $articulo) {
    $carrito = Carrito::carrito();
    $carrito->meter($articulo->id);
    session()->put('carrito', $carrito);
    return redirect()->route('articulos.index');
})->name('carrito.meter');

Route::get('/carrito/sacar/{articulo}', function (Articulo $articulo) {
    $carrito = Carrito::carrito();
    $carrito->sacar($articulo->id);
    session()->put('carrito', $carrito);
    return redirect()->route('articulos.index');
})->name('carrito.sacar');

Route::get('/carrito/vaciar', function () {
    session()->forget('carrito');
    return redirect()->route('articulos.index');
})->name('carrito.vaciar');

Route::post('/comprar', function () {
    DB::beginTransaction();
    $carrito = Carrito::carrito();
    $factura = new Factura();
    $factura->numero = Str::uuid(); //genera un uuid aleatorio
    $factura->user()->associate(Auth::user());
    $factura->save();
    // die();
    $attachs = [];
    foreach ($carrito->getLineas() as $articulo_id => $linea) {
        $attachs[$articulo_id] = ['cantidad' => $linea->getCantidad()];
    }
    $factura->articulos()->attach($attachs);
    DB::commit();
    session()->forget('carrito');
    return redirect()->route('facturas.index');
})->middleware('auth')->name('comprar');

require __DIR__.'/auth.php';

/*
Route::post('/comprar/numero_fatura', function(){
    return view('comprar.numero_factura'); //retorna a la vista de la carpeta 'comprar' -> numero_factura.blade.php
})->name('generar.numero_factura');
*/
