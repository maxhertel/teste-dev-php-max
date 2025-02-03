<?php

namespace Tests\Unit;

use App\Models\Fornecedor;
use PHPUnit\Framework\TestCase;

class FornecedorTest extends TestCase
{
    public function test_sanitize_document_removes_non_numeric_characters()
    {
        $document = '123.456.789-09';
        $sanitized = Fornecedor::sanitizeDocument($document);
        
        $this->assertEquals('12345678909', $sanitized);
    }

    public function test_is_valid_cpf_returns_true_for_valid_cpf()
    {
        $validCpf = '52998224725'; // CPF válido
        $this->assertTrue(Fornecedor::isValidCPF($validCpf));
    }

    public function test_is_valid_cpf_returns_false_for_invalid_cpf()
    {
        $invalidCpf = '11111111111'; // CPF inválido (todos iguais)
        $this->assertFalse(Fornecedor::isValidCPF($invalidCpf));
    }

    public function test_is_valid_cnpj_returns_true_for_valid_cnpj()
    {
        $validCnpj = '11444777000161'; // CNPJ válido
        $this->assertTrue(Fornecedor::isValidCNPJ($validCnpj));
    }

    public function test_is_valid_cnpj_returns_false_for_invalid_cnpj()
    {
        $invalidCnpj = '11111111111111'; // CNPJ inválido (todos iguais)
        $this->assertFalse(Fornecedor::isValidCNPJ($invalidCnpj));
    }
}
