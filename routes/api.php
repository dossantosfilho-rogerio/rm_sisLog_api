<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\RotaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendaController;
use App\Models\Rota;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login'])->name('login');


// Rotas protegidas com auth:sanctum, ou seja, possuem token
Route::middleware('auth:sanctum')->group(function () {
    // Rota para logout (revogar o token)
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/createCompra', [CompraController::class, 'createCompra']);
    Route::post('/createPessoa', [PessoaController::class, 'createPessoa']);
    Route::post('/createProduto', [ProdutoController::class, 'createProduto']);
    Route::post('/createCategoria', [CategoriaController::class, 'createCategoria']);
    Route::post('/createRota', [RotaController::class, 'createRota']);
    Route::post('/createVenda', [VendaController::class, 'createVenda']);

    Route::get('/listVendas', [VendaController::class, 'listVendas']);
    Route::get('/listRotas', [RotaController::class, 'listRotas']);
    Route::get('/listRotasSelect', [RotaController::class, 'listRotasSelect']);
    Route::get('/listProdutos', [ProdutoController::class, 'listProdutos']);
    Route::get('/listProdutosSelect', [ProdutoController::class, 'listProdutosSelect']);
    Route::get('/listCompras', [CompraController::class, 'listCompras']);
    Route::get('/listPessoas', [PessoaController::class, 'listPessoas']);
    Route::get('/listCategorias', [CategoriaController::class, 'listCategorias']);
    Route::get('/listCategoriasSelect', [CategoriaController::class, 'listCategoriasSelect']);


});