<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="Fornecedor",
 *     type="object",
 *     title="Fornecedor",
 *     required={"nome", "cnpj_cpf", "tipo_documento"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
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
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         example="2025-02-01T00:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         example="2025-02-01T00:00:00Z"
 *     )
 * )
 */
class Fornecedor extends Model
{
    protected $fillable = [
        'nome',
        'cnpj_cpf',
        'tipo_documento',
        'email',
        'telefone',
        'rua',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'observacoes',
    ];
      /**
     * Boot do model para aplicar callbacks.
     */
    protected static function boot()
    {
        parent::boot();

        // Exemplo de callback para remover caracteres especiais do CNPJ/CPF antes de salvar
        static::saving(function ($supplier) {
            $supplier->cnpj_cpf = self::sanitizeDocument($supplier->cnpj_cpf);
        });
    }
    public static function sanitizeDocument(string $document): string
    {
        return preg_replace('/\D/', '', $document);
    }
    public static function isValidDocument(string $document, string $type): bool
    {
        $document = self::sanitizeDocument($document);

        if ($type === 'cpf') {
            return self::isValidCPF($document);
        } elseif ($type === 'cnpj') {
            return self::isValidCNPJ($document);
        }

        return false;
    }
    private static function isValidCPF(string $cpf): bool
    {
        // Verifica se foi informado um CPF com 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/^(.)\1{10}$/', $cpf)) {
            return false;
        }

        // Validação dos dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$t] != $d) {
                return false;
            }
        }
        return true;
    }
    private static function isValidCNPJ(string $cnpj): bool
    {
        // Verifica se foi informado um CNPJ com 14 dígitos
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/^(.)\1{13}$/', $cnpj)) {
            return false;
        }

        // Validação dos dígitos verificadores
        $tamanho = strlen($cnpj) - 2;
        $numeros = substr($cnpj, 0, $tamanho);
        $digitos = substr($cnpj, $tamanho);
        $soma = 0;
        $pos = $tamanho - 7;
        for ($i = $tamanho; $i >= 1; $i--) {
            $soma += $numeros[$tamanho - $i] * $pos--;
            if ($pos < 2) {
                $pos = 9;
            }
        }
        $resultado = $soma % 11 < 2 ? 0 : 11 - ($soma % 11);
        if ($resultado != $digitos[0]) {
            return false;
        }

        $tamanho = $tamanho + 1;
        $numeros = substr($cnpj, 0, $tamanho);
        $soma = 0;
        $pos = $tamanho - 7;
        for ($i = $tamanho; $i >= 1; $i--) {
            $soma += $numeros[$tamanho - $i] * $pos--;
            if ($pos < 2) {
                $pos = 9;
            }
        }
        $resultado = $soma % 11 < 2 ? 0 : 11 - ($soma % 11);
        if ($resultado != $digitos[1]) {
            return false;
        }
        return true;
    }
}
