<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ChapterController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PurchaseController;

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes that require authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Route to handle course purchase
    Route::post('/purchase-course/{id}', [PurchaseController::class, 'purchaseCourse']);

    // Route to display purchased courses
    Route::get('/purchased-courses', [UserController::class, 'purchasedCourses']);

    // Route to add a comment and rating to a course
    Route::post('/courses/{id}/comments', [CommentController::class, 'store']);

    // Admin Routes using Spatie's role middleware
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [UserController::class, 'index']);

        // Admin-specific Category Routes
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('categories/{id}', [CategoryController::class, 'update']);
        Route::delete('categories/{id}', [CategoryController::class, 'destroy']);

        // Admin-specific Course Routes
        Route::post('courses', [CourseController::class, 'store']);
        Route::put('courses/{id}', [CourseController::class, 'update']);
        Route::delete('courses/{id}', [CourseController::class, 'destroy']);

        // Admin-specific Chapter Routes
        Route::post('chapters', [ChapterController::class, 'store']);
        Route::put('chapters/{chapter_id}', [ChapterController::class, 'update']);

        // Route to check if a user is an admin
        Route::get('/check-roles/{user}', [UserController::class, 'checkRoles']);

    });

    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Public Category Routes
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}', [CategoryController::class, 'show']);

// Public Course Routes
Route::get('courses', [CourseController::class, 'index']);
Route::get('courses/{id}', [CourseController::class, 'show']);
Route::get('/courses/search/{class_name}', [CourseController::class, 'searchByClassName']);

// Route to view comments and ratings for a course (publicly accessible)
Route::get('/courses/{id}/comments', [CommentController::class, 'index']);
