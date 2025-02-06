<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login'])->name('login');


// Rotas protegidas com auth:sanctum, ou seja, possuem token
Route::middleware('auth:sanctum')->group(function () {
    // Rota para logout (revogar o token)
    Route::post('/logout', [UserController::class, 'logout']);


});