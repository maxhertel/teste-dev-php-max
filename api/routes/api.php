<?php

use App\Http\Controllers\FornecedorController;
use Illuminate\Support\Facades\Route;

Route::prefix('fornecedor')->group(function () {
    Route::get('/', [FornecedorController::class, 'index']);

    Route::post('/', [FornecedorController::class, 'store']);

    Route::put('/{id}', [FornecedorController::class, 'update']);

    Route::delete('/{id}', [FornecedorController::class, 'destroy']);

    Route::get('/{id}/consultar-cnpj-externo', [FornecedorController::class, 'consultarCnpj']);

});