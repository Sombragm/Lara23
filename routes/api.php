<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

// CRUD Categorías
Route::get('/categorias',          [CategoryController::class, 'index']);
Route::post('/categorias',         [CategoryController::class, 'store']);
Route::get('/categorias/{id}',     [CategoryController::class, 'show']);
Route::put('/categorias/{id}',     [CategoryController::class, 'update']);
Route::delete('/categorias/{id}',  [CategoryController::class, 'destroy']);

// CRUD Productos
Route::get('/productos',           [ProductController::class, 'index']);
Route::post('/productos',          [ProductController::class, 'store']);
Route::get('/productos/{id}',      [ProductController::class, 'show']);
Route::put('/productos/{id}',      [ProductController::class, 'update']);
Route::delete('/productos/{id}',   [ProductController::class, 'destroy']);
