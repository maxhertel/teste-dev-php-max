<?php

namespace App\Http\Requests;

use App\Models\Fornecedor;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="FornecedorRequest",
 *     type="object",
 *     title="FornecedorRequest",
 *     required={"nome", "cnpj_cpf", "tipo_documento"},
 *     @OA\Property(
 *         property="nome",
 *         type="string",
 *         example="Fornecedor Exemplo"
 *     ),
 *     @OA\Property(
 *         property="cnpj_cpf",
 *         type="string",
 *         example="12345678901234"
 *     ),
 *     @OA\Property(
 *         property="tipo_documento",
 *         type="string",
 *         enum={"cpf", "cnpj"},
 *         example="cnpj"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         example="contato@fornecedor.com"
 *     ),
 *     @OA\Property(
 *         property="telefone",
 *         type="string",
 *         example="(11) 99999-9999"
 *     ),
 *     @OA\Property(
 *         property="rua",
 *         type="string",
 *         example="Rua Exemplo"
 *     ),
 *     @OA\Property(
 *         property="numero",
 *         type="string",
 *         example="100"
 *     ),
 *     @OA\Property(
 *         property="complemento",
 *         type="string",
 *         example="Apto 101"
 *     ),
 *     @OA\Property(
 *         property="bairro",
 *         type="string",
 *         example="Centro"
 *     ),
 *     @OA\Property(
 *         property="cidade",
 *         type="string",
 *         example="São Paulo"
 *     ),
 *     @OA\Property(
 *         property="estado",
 *         type="string",
 *         example="SP"
 *     ),
 *     @OA\Property(
 *         property="cep",
 *         type="string",
 *         example="01000-000"
 *     ),
 *     @OA\Property(
 *         property="observacoes",
 *         type="string",
 *         example="Observações sobre o fornecedor."
 *     )
 * )
 */
class FornecedorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ajuste conforme sua política de autorização
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome'          => 'required|string|max:255',
            'cnpj_cpf'      => [
                'required',
                'string',
                'max:20',
                // Exemplo de callback inline para validação customizada:
                function ($attribute, $value, $fail) {
                    $value = Fornecedor::sanitizeDocument($value);
                    $documentType = $this->input('document_type');

                    if ($documentType === 'cpf' && !Fornecedor::isValidDocument($value, 'cpf')) {
                        $fail('O CPF informado é inválido.');
                    } elseif ($documentType === 'cnpj' && !Fornecedor::isValidDocument($value, 'cnpj')) {
                        $fail('O CNPJ informado é inválido.');
                    }
                    if (Fornecedor::where('cnpj_cpf', $value)
                        ->where('id', '!=', request()->route('fornecedor'))
                        ->exists()
                    ) {
                        $fail('O documento informado já está cadastrado.');
                    }
                },
            ],
            'tipo_documento' => 'required|in:cpf,cnpj',
            'email'         => 'nullable|email|max:255',
            'telefone'         => 'nullable|string|max:20',
            'rua'        => 'nullable|string|max:255',
            'numero'        => 'nullable|string|max:10',
            'complemento'    => 'nullable|string|max:255',
            'bairro'      => 'nullable|string|max:255',
            'cidade'          => 'nullable|string|max:255',
            'estado'         => 'nullable|string|size:2',
            'cep'      => 'nullable|string|max:10',
            'observacoes'         => 'nullable|string',
        ];
    }
}
