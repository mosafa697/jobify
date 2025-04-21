
<?php

use App\Http\Controllers\Auth\CandidateController;
use App\Http\Controllers\Auth\CompanyController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobPostController;
use Illuminate\Support\Facades\Route;

Route::post('company/login', [CompanyController::class, 'login']);
Route::post('company/logout', [CompanyController::class, 'logout']);
// Protect company routes
Route::middleware('auth:company')->group(function () {
    Route::apiResource('job-posts', JobPostController::class);
});

Route::post('candidate/login', [CandidateController::class, 'login']);
Route::post('candidate/logout', [CandidateController::class, 'logout']);
// Protect candidate routes
Route::middleware('auth:candidate')->group(function () {
    Route::post('/jobs/{id}/apply', [JobApplicationController::class, 'apply']);
});
