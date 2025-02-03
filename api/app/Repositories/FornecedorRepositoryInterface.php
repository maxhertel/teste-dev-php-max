<?php

namespace App\Repositories;

use App\Models\Fornecedor;
use App\Models\Supplier;

interface FornecedorRepositoryInterface
{
    /**
     * Recupera todos os fornecedores.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Fornecedor[]
     */
    public function getAll();

    /**
     * Cadastra um novo fornecedor.
     *
     * @param  array  $data
     * @return Supplier
     */
    public function create(array $data): Fornecedor;

    /**
     * Recupera um fornecedor pelo ID.
     *
     * @param  int  $id
     * @return Supplier|null
     */
    public function find(int $id): ?Fornecedor;
    
    
}
