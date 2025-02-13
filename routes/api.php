<?php

use App\Http\Controllers\CompraController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login'])->name('login');


// Rotas protegidas com auth:sanctum, ou seja, possuem token
Route::middleware('auth:sanctum')->group(function () {
    // Rota para logout (revogar o token)
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/createCompra', [CompraController::class, 'createCompra']);
    Route::post('/createPessoa', [PessoaController::class, 'createPessoa']);


    
    Route::get('/listProdutos', [ProdutoController::class, 'listProdutos']);
    Route::get('/listProdutosSelect', [ProdutoController::class, 'listProdutosSelect']);
    Route::get('/listCompras', [CompraController::class, 'listCompras']);
    Route::get('/listPessoas', [PessoaController::class, 'listPessoas']);
});