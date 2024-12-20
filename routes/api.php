<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return "hey";
// })->middleware('auth:sanctum');

Route::post('/authenticate', AuthController::class)->name('login')->middleware(['throttle:5,1']);

Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::apiResource('/properties', PropertyController::class)->only('store', 'update', 'destroy')->middleware('auth:sanctum');

// Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
