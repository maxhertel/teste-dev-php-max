<?php

use App\Http\Controllers\FornecedorController;
use App\Models\Fornecedor;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\Return_;

Route::get('/', function () {
    return response()->json("bem vindo a api de cadastro de fornedores");
});

Route::get('/suppliers', [FornecedorController::class, 'index']);
Route::post('/suppliers', [FornecedorController::class, 'store']);