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


    /**
     * Atualiza um fornecedor existente.
     *
     * @param int $id
     * @param array $data
     * @return Fornecedor|null Retorna o fornecedor atualizado ou null caso não seja encontrado.
     */
    public function update(int $id, array $data): ?Fornecedor;

    /**
     * Exclui um fornecedor pelo ID.
     *
     * @param int $id
     * @return bool Retorna true se a exclusão for bem-sucedida, false caso contrário.
     */
    public function delete(int $id): bool;
}
