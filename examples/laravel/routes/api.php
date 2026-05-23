<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Contoh Route SATUSEHAT API
|--------------------------------------------------------------------------
*/

Route::prefix('satusehat')->group(function () {

    // Patient
    Route::get('patients/search', [PatientController::class, 'search']);
    Route::get('patients/nik/{nik}', [PatientController::class, 'findByNik']);
    Route::get('patients/{id}', [PatientController::class, 'show']);

});
