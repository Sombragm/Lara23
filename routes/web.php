<?php

use App\Http\Controllers\CtrlForms;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ctrlDatos;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/datos', [ctrlDatos::class, 'AccesoDatosVista']);

Route::get('/datoslink', [ctrlDatos::class, 'AccesoDatosVistaLink'])->name('vistadatos');

Route::get('/datoslinkC', [ctrlDatos::class, 'AccesoDatosVistaLinkC']);

Route::get('/detalles/{id}', [ctrlDatos::class, 'Detalles'])->name('detalles');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/categorias', [CtrlForms::class, 'Categorias'])->name('categorias');
Route::post('/categorias', [CtrlForms::class, 'storeCategoria'])->name('categorias.store');
Route::get('/categorias/{id}/edit', [CtrlForms::class, 'editCategoria'])->name('categorias.edit');
Route::put('/categorias/{id}', [CtrlForms::class, 'updateCategoria'])->name('categorias.update');
Route::delete('/categorias/{id}', [CtrlForms::class, 'destroyCategoria'])->name('categorias.destroy');

Route::get('/productos', [CtrlForms::class, 'Productos'])->name('productos');
Route::post('/productos', [CtrlForms::class, 'storeProduct'])->name('productos.store');
Route::get('/productos/{id}/edit', [CtrlForms::class, 'editProduct'])->name('productos.edit');
Route::put('/productos/{id}', [CtrlForms::class, 'updateProduct'])->name('productos.update');
Route::delete('/productos/{id}', [CtrlForms::class, 'destroyProduct'])->name('productos.destroy');

require __DIR__.'/auth.php';
