<?php


use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;


Route::middleware(['decode.jwt'])->group(function () {
    // Patient
    Route::apiResource('patients', PatientController::class);
   
});

