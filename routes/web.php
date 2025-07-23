<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KalenderController;

Route::get('/', function () {
    return view('kalender');
});

Route::get('/admin/login', function () {
    return view('login');
});

Route::get('/admin/kalender', function () {
    return view('kalenderAdmin');
});

// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/kalender', function () {
//         return view('kalenderAdmin');
//     });
// });