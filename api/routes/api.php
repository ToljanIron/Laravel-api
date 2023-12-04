<?php

use App\Http\Controllers\Api\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->middleware('verify.email')->name('login');
Route::get('/verify-email/{id}/{token}', [AuthController::class, 'verify'])->name('verify.email');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user-addresses', [ProfileController::class, 'show'])->name('show');
    Route::post('/user-addresses', [ProfileController::class, 'store'])->name('store');
    Route::put('/user-addresses', [ProfileController::class, 'update'])->name('update');
    Route::delete('/user-addresses', [ProfileController::class, 'destroy'])->name('destroy');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});



