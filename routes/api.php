<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('api')->group(function () {
    Route::get('/test', function () {
        return response()->json(['message' => 'Hello, world!']);
    });

    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::prefix('/post')->group(function () {
            Route::post('/', [PostController::class, 'createPost'])->name('createPost');
            Route::get('/', [PostController::class, 'readPosts'])->name('readPosts');
            Route::put('/{id}', [PostController::class, 'updatePost'])->name('updatePost');
            Route::delete('/{id}', [PostController::class, 'deletePost'])->name('deletePost');
        });
    });
});