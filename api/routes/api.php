<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
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

    Route::post('/user-upload-avatar', [ProfileController::class, 'uploadAvatar'])->name('upload.avatar');
    Route::put('/user-update-avatar', [ProfileController::class, 'updateAvatar'])->name('update.avatar');
    Route::delete('/user-remove-avatar', [ProfileController::class, 'removeAvatar'])->name('remove.avatar');

    Route::get('/list-users', [AdminController::class, 'getUsers'])->name('list.users');
    Route::post('/seed-users', [AdminController::class, 'seedUsers'])->name('seed.users');

    Route::get('/chat/create/{id}', [ChatController::class, 'create'])->name('create.chat');
    Route::get('/chats', [ChatController::class, 'getChats'])->name('user.chats');
    Route::get('/chat/{id}', [ChatController::class, 'getChatById'])->name('chat');
    Route::delete('/delete/chat/{id}', [ChatController::class, 'delete'])->name('delete.chat');

    Route::post('/send/message', [MessageController::class, 'send'])->name('send.message');
    Route::put('/update/message/{id}', [MessageController::class, 'update'])->name('update.message');
    Route::delete('/delete/message/{id}', [MessageController::class, 'delete'])->name('delete.message');

    Route::post('/chat/search-user',[UserController::class, 'searchUsers'])->name('search.user');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});



