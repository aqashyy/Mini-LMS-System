<?php

use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('apiLogger')->group(function () {

    // auth routes
    Route::post('login',[AuthController::class,'login']);

    // public routes


    // Authed routes
    Route::middleware(['auth:sanctum'])->group(function () {
        // admin role based resource routes
        
        Route::apiResource('admin/courses',CourseController::class)->middleware('is_admin')->except('index');
        
        // admin and students routes
        Route::controller(CourseController::class)->group(function () {

            Route::get('courses','index');
            Route::get('course/enroll/{id}','enrolnow');
            Route::get('mycourses','myCourses');
            Route::get('course/search','search');
        });
    });

});