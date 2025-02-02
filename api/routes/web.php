<?php

use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\Return_;

Route::get('/', function () {
    return response()->json("bem vindo a api de cadastro de fornedores");
});
