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

        /**
     * Atualiza um fornecedor existente.
     *
     * @param int $id
     * @param array $data
     * @return Fornecedor|null Retorna o fornecedor atualizado ou null caso não seja encontrado.
     */
    public function update(int $id, array $data): ?Fornecedor
    {
        $fornecedor = $this->find($id);
        if (!$fornecedor) {
            return null;
        }

        $fornecedor->update($data);
        return $fornecedor;
    }

    /**
     * Exclui um fornecedor pelo ID.
     *
     * @param int $id
     * @return bool Retorna true se a exclusão for bem-sucedida, false caso contrário.
     */
    public function delete(int $id): bool
    {
        $fornecedor = $this->find($id);
        if (!$fornecedor) {
            return false;
        }

        return $fornecedor->delete();
    }
}
