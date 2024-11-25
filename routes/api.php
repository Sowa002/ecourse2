<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ChapterController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\PurchaseController;

// Public routes
Route::get('courses', [CourseController::class, 'index']);
Route::get('courses/{id}', [CourseController::class, 'showWithoutAuth']);
Route::get('/courses/search/{class_name}', [CourseController::class, 'searchByClassName']);

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('courses/{id}', [CourseController::class, 'show']); // This route requires authentication
    Route::post('/purchase-course/{id}', [PurchaseController::class, 'purchaseCourse']);
    Route::get('/purchased-courses', [UserController::class, 'purchasedCourses']);
    Route::post('/courses/{id}/comments', [CommentController::class, 'store']);
    Route::get('/courses/{id}/comments', [CommentController::class, 'index']);
    Route::get('videos', [VideoController::class, 'index']);
    Route::get('videos/{id}', [VideoController::class, 'show']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Admin routes (if applicable)
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{id}', [CategoryController::class, 'update']);
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
    Route::post('courses', [CourseController::class, 'store']);
    Route::put('courses/{id}', [CourseController::class, 'update']);
    Route::delete('courses/{id}', [CourseController::class, 'destroy']);
    Route::post('chapters', [ChapterController::class, 'store']);
    Route::put('chapters/{chapter_id}', [ChapterController::class, 'update']);
    Route::post('videos', [VideoController::class, 'store']);
    Route::put('videos/{id}', [VideoController::class, 'update']);
    Route::delete('videos/{id}', [VideoController::class, 'destroy']);
});
