<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;

Route::post('/register', [RegisterController::class, 'store']);

Route::post('/note', [NoteController::class, 'store']);

Route::get('/notes', [NoteController::class, 'index']);

Route::put('/noteses/{id}', [NoteController::class, 'update']);

Route::delete('/noteseses/{id}', [NoteController::class, 'destroy']);

Route::post('/login', [LoginController::class, 'check']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});
