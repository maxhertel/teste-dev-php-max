<?php

namespace App\Http\Controllers;

use App\Http\Requests\FornecedorRequest;
use App\Jobs\ProcessarNovoRegistro;
use App\Repositories\FornecedorRepositoryInterface;
use Illuminate\Support\Facades\Request;

/**
 * @OA\Tag(
 *     name="Fornecedores",
 *     description="Endpoints para gerenciamento de fornecedores"
 * )
 */
class FornecedorController extends Controller
{
    /**
     * @var fornecedorRepositoryInterface
     */
    protected $fornecedorRepository;

    /**
     * Injeta a dependência do repositório.
     *
     * @param FornecedorRepositoryInterface $fornecedorRepository
     */
    public function __construct(FornecedorRepositoryInterface $fornecedorRepository)
    {
        $this->fornecedorRepository = $fornecedorRepository;
    }

    /**
     * Lista todos os fornecedores.
     *
     * @OA\Get(
     *     path="/api/fornecedor",
     *     operationId="getFornecedoresList",
     *     tags={"Fornecedores"},
     *     summary="Lista fornecedores",
     *     description="Retorna uma lista de todos os fornecedores cadastrados.",
     *     @OA\Response(
     *         response=200,
     *         description="Operação realizada com sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Fornecedor")
     *         )
     *     )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $suppliers = $this->fornecedorRepository->getAll();

        return response()->json($suppliers);
    }

    /**
     * Cadastra um novo fornecedor.
     *
     * @OA\Post(
     *     path="/api/fornecedor",
     *     operationId="storeFornecedor",
     *     tags={"Fornecedores"},
     *     summary="Cadastra fornecedor",
     *     description="Cadastra um novo fornecedor utilizando os dados informados.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados do fornecedor",
     *         @OA\JsonContent(ref="#/components/schemas/FornecedorRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Fornecedor cadastrado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Fornecedor cadastrado com sucesso!"
     *             ),
     *             @OA\Property(
     *                 property="supplier",
     *                 ref="#/components/schemas/Fornecedor"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     *
     * @param  FornecedorRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FornecedorRequest $request)
    {
        $fornecedor = $this->fornecedorRepository->create($request->validated());

        // Despacha o job para processar o fornecedor imediatamente:
        ProcessarNovoRegistro::dispatch($fornecedor);

        return response()->json([
            'message'  => 'Fornecedor cadastrado com sucesso!',
            'supplier' => $fornecedor,
        ], 201);
    }

    /**
     * Atualiza um fornecedor existente.
     *
     * @OA\Put(
     *     path="/api/fornecedor/{id}",
     *     operationId="updateFornecedor",
     *     tags={"Fornecedores"},
     *     summary="Atualiza fornecedor",
     *     description="Atualiza os dados de um fornecedor existente.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do fornecedor a ser atualizado",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados para atualização do fornecedor",
     *         @OA\JsonContent(ref="#/components/schemas/FornecedorRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Fornecedor atualizado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Fornecedor atualizado com sucesso!"
     *             ),
     *             @OA\Property(
     *                 property="supplier",
     *                 ref="#/components/schemas/Fornecedor"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Fornecedor não encontrado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     *
     * @param  int  $id
     * @param  FornecedorRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id, FornecedorRequest $request)
    {
        // Procura o fornecedor pelo ID
        $supplier = $this->fornecedorRepository->find($id);

        if (!$supplier) {
            return response()->json(['message' => 'Fornecedor não encontrado'], 404);
        }

        // Atualiza o fornecedor com os dados validados
        $supplier->update($request->validated());

        return response()->json([
            'message'  => 'Fornecedor atualizado com sucesso!',
            'supplier' => $supplier,
        ]);
    }

    /**
     * Exclui um fornecedor existente.
     *
     * @OA\Delete(
     *     path="/api/fornecedor/{id}",
     *     operationId="deleteFornecedor",
     *     tags={"Fornecedores"},
     *     summary="Exclui fornecedor",
     *     description="Exclui um fornecedor pelo seu ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do fornecedor a ser excluído",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Fornecedor excluído com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Fornecedor excluído com sucesso!"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Fornecedor não encontrado ou não pôde ser excluído"
     *     )
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $deleted = $this->fornecedorRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Fornecedor não encontrado ou não pôde ser excluído'], 404);
        }

        return response()->json(['message' => 'Fornecedor excluído com sucesso!']);
    }
}
