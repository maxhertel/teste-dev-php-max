<?php

namespace App\Http\Controllers;

use App\Http\Requests\FornecedorRequest;
use App\Http\Requests\SupplierRequest;
use App\Models\Fornecedor;
use App\Repositories\FornecedorRepositoryInterface;
use App\Repositories\SupplierRepositoryInterface;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Suppliers",
 *     description="Endpoints para gerenciamento de fornecedores"
 * )
 */
class FornecedorController extends Controller
{
    /**
     * @var SupplierRepositoryInterface
     */
    protected $supplierRepository;

    /**
     * Injeta a dependência do repositório.
     *
     * @param SupplierRepositoryInterface $supplierRepository
     */
    public function __construct(FornecedorRepositoryInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

/**
     * Lista todos os fornecedores.
     *
     * @OA\Get(
     *     path="/api/fornecerdor",
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
        $suppliers = $this->supplierRepository->getAll();

        return response()->json($suppliers);
    }

    /**
     * Cadastra um novo fornecedor.
     *
     * @OA\Post(
     *     path="/api/fornecerdor",
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
        $supplier = $this->supplierRepository->create($request->validated());

        return response()->json([
            'message'  => 'Fornecedor cadastrado com sucesso!',
            'supplier' => $supplier,
        ], 201);
    }
}
