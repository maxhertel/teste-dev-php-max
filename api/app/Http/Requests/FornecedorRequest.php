<?php

namespace App\Http\Requests;

use App\Models\Fornecedor;
use Illuminate\Foundation\Http\FormRequest;

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
            'name'          => 'required|string|max:255',
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
                },
            ],
            'document_type' => 'required|in:cpf,cnpj',
            'email'         => 'nullable|email|max:255',
            'phone'         => 'nullable|string|max:20',
            'street'        => 'nullable|string|max:255',
            'number'        => 'nullable|string|max:10',
            'complement'    => 'nullable|string|max:255',
            'district'      => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:255',
            'state'         => 'nullable|string|size:2',
            'zip_code'      => 'nullable|string|max:10',
            'obs'         => 'nullable|string',
        ];
    }
}
