<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DonorMemberController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\DidRegistrationController;
use App\Http\Controllers\DonationController;
use App\Models\Gallery;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public Login Route
Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);


// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// routes/api.php
Route::post('/import-medical-colleges', [CollegeController::class, 'import']);


Route::middleware(['auth:sanctum'])
    ->prefix('profiles')->controller(ProfileController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{id}/edit', 'edit');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::post('/designations', [DesignationController::class, 'store']);
Route::get('/donations', [DonationController::class, 'index']);
Route::post('/donations', [DonationController::class, 'store']);

Route::post('/donor-members', [DonorMemberController::class, 'store']);
Route::get('/admin/donor-members', [DonorMemberController::class, 'index']);
Route::get('/admin/donor-members/{id}', [DonorMemberController::class, 'show']);


Route::get('/donors', [DonationController::class, 'index'])
->middleware(['auth:sanctum', 'isAdmin']);

Route::middleware(['auth:sanctum', 'isAdmin'])
    ->prefix('activities')
    ->controller(ActivityController::class)
    ->group(function () {
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

Route::prefix('activities')
    ->controller(ActivityController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    });

// 🔐 Admin-only News routes
Route::middleware(['auth:sanctum', 'isAdmin'])
    ->prefix('news')
    ->controller(NewsController::class)
    ->name('admin.news.') // ✅ named route prefix
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

// 🌐 Public News routes
Route::prefix('news')
    ->controller(NewsController::class)
    ->name('public.news.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
    });
// 🔐 Admin-only News routes
Route::middleware(['auth:sanctum', 'isAdmin'])
    ->prefix('galleries')
    ->controller(GalleryController::class)
    ->name('admin.galleries.') // ✅ named route prefix
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

// 🌐 Public News routes
Route::prefix('galleries')
    ->controller(GalleryController::class)
    ->name('public.galleries.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
    });

Route::middleware(['auth:sanctum', 'isAdmin'])
    ->prefix('about-us')
    ->controller(AboutUsController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

Route::prefix('about-us')
    ->controller(AboutUsController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    });

Route::prefix('did')->group(function () {
    Route::post('/register', [DidRegistrationController::class, 'store']);
    Route::put('/register/{didRegistration}', [DidRegistrationController::class, 'update']);
    Route::get('/all', [DidRegistrationController::class, 'index']);
    Route::get('/{didRegistration}', [DidRegistrationController::class, 'show']);
    Route::delete('/{didRegistration}', [DidRegistrationController::class, 'destroy']);
});

Route::get('colleges', [CollegeController::class, 'index']);