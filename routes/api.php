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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/kegiatan', [KalenderController::class, 'getEvents']);
    Route::post('/admin/create-kegiatan', [KalenderController::class, 'store']);
    Route::put('/admin/update-kegiatan/{id}', [KalenderController::class, 'update']);
    Route::delete('/admin/delete-kegiatan/{id}', [KalenderController::class, 'delete']);
    Route::post('/admin/logout', [UserController::class, 'logout']);
});


