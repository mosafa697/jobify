
<?php

use App\Http\Controllers\Auth\CandidateController;
use App\Http\Controllers\Auth\CompanyController;
use Illuminate\Support\Facades\Route;

Route::post('company/login', [CompanyController::class, 'login']);
Route::post('company/logout', [CompanyController::class, 'logout']);
// Protect company routes
Route::middleware('auth:company')->get('/company/dashboard', function () {
    return response()->json(['message' => 'Company Dashboard']);
});

Route::post('candidate/login', [CandidateController::class, 'login']);
Route::post('candidate/logout', [CandidateController::class, 'logout']);
// Protect candidate routes
Route::middleware('auth:candidate')->get('/candidate/dashboard', function () {
    return response()->json(['message' => 'Candidate Dashboard']);
});
