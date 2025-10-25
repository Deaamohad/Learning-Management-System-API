<?php

use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\EnrollmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('courses', CourseController::class);
Route::apiResource('enrollments', EnrollmentController::class)->middleware('auth:sanctum');
Route::get('/courses/{course}/students', [EnrollmentController::class, 'courseStudents'])->middleware('auth:sanctum');
Route::get('/my-enrollments', [EnrollmentController::class, 'userEnrollments'])->middleware('auth:sanctum');
