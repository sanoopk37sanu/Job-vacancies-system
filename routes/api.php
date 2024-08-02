<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\VacancyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/jobs', [JobController::class, 'index']);
Route::post('/add-vacancy', [VacancyController::class, 'create']);
Route::get('/vacancy-list', [VacancyController::class, 'index']);
Route::post('/vacancy-update/{id}', [VacancyController::class, 'update']);
Route::delete('/vacancy-delete/{id}', [VacancyController::class, 'destroy']);
