<?php


use App\Http\Controllers\PatientController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;


Route::middleware(['decode.jwt'])->group(function () {
    // Patient
    Route::apiResource('patients', PatientController::class);

    // Service
    Route::apiResource('services', ServiceController::class);
   
});

