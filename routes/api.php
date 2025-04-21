
<?php

use App\Http\Controllers\Auth\CandidateController;
use App\Http\Controllers\Auth\CompanyController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobPostController;
use Illuminate\Support\Facades\Route;

Route::prefix('company')->group(function () {
    Route::post('register', [CompanyController::class, 'register']);
    Route::post('login', [CompanyController::class, 'login']);
    
    Route::middleware('auth:company')->group(function () {
        Route::post('logout', [CompanyController::class, 'logout']);
        Route::apiResource('job-posts', JobPostController::class);
        Route::get('job-posts/{id}/restore', [JobPostController::class, 'restore']);
    });
});

Route::prefix('candidate')->group(function () {
    Route::post('register', [CandidateController::class, 'register']);
    Route::post('login', [CandidateController::class, 'login']);
    // Protect candidate routes
    Route::middleware('auth:candidate')->group(function () {
        Route::post('logout', [CandidateController::class, 'logout']);
        Route::post('/jobs/{id}/apply', [JobApplicationController::class, 'apply']);
    });
});

Route::post('candidate/jobs/{id}/apply', [JobApplicationController::class, 'apply']);