<?php

namespace App\Repositories;

use App\Models\Fornecedor;

class FornecedorRepository implements FornecedorRepositoryInterface
{
    /**
     * Recupera todos os fornecedores.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Fornecedor[]
     */
    public function getAll()
    {
        return Fornecedor::all();
    }

    /**
     * Cadastra um novo fornecedor.
     *
     * @param  array  $data
     * @return Fornecedor
     */
    public function create(array $data): Fornecedor
    {
        return Fornecedor::create($data);
    }

    /**
     * Recupera um fornecedor pelo ID.
     *
     * @param  int  $id
     * @return Supplier|null
     */
    public function find(int $id): ?Fornecedor
    {
        return Fornecedor::find($id);
    }
}
