<?php

use App\Http\Controllers\FornecedorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json("bem vindo a api de cadastro de fornedores");
});