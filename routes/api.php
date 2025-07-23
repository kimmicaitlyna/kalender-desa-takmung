<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KalenderController;
use App\Http\Controllers\UserController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/kalender/events', [KalenderController::class, 'getEvents']);
Route::post('/admin/login', [UserController::class, 'login']);
Route::post('/admin/register', [UserController::class, 'registerAdmin']);

// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::resource('/admin/kegiatan', [KalenderController::class, 'getEvents']);
// });

// Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/admin/kegiatan', [KalenderController::class, 'getEvents']);
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/kegiatan', [KalenderController::class, 'getEvents']);
    Route::post('/admin/create-kegiatan', [KalenderController::class, 'store']);

    Route::delete('/admin/delete-kegiatan/{id}', [KalenderController::class, 'delete']);
});

