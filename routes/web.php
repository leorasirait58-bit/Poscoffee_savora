<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\MejaController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[FrontController::class, 'index'])->name('front.index');
Route::post('/update-meja/{id}', [MejaController::class, 'updateStatus']);