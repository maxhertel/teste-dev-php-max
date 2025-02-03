<?php

use App\Http\Controllers\FornecedorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('fornecedor')->group(function () {
    Route::get('/', [FornecedorController::class, 'index']);

    Route::post('/', [FornecedorController::class, 'store']);

    Route::put('/{id}', [FornecedorController::class, 'update']);

    Route::delete('/{id}', [FornecedorController::class, 'destroy']);
});