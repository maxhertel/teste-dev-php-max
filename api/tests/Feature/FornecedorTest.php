<?php

namespace Tests\Feature;

use App\Models\Fornecedor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FornecedorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pode_cadastrar_um_fornecedor_com_dados_validos()
    {
        $dados = [
            'nome' => 'Fornecedor Teste',
            'cnpj_cpf' => '12.345.678/0001-95', // CNPJ válido formatado
            'tipo_documento' => 'cnpj',
            'email' => 'fornecedor@example.com',
            'telefone' => '(11) 98765-4321',
            'rua' => 'Rua Teste',
            'numero' => '123',
            'complemento' => 'Sala 101',
            'bairro' => 'Centro',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01000-000',
            'observacoes' => 'Fornecedor de testes.',
        ];

        $response = $this->postJson('/api/fornecedores', $dados);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id', 'nome', 'cnpj_cpf', 'tipo_documento', 'email', 'telefone', 'rua', 'numero', 'bairro', 'cidade', 'estado', 'cep'
                 ]);

        $this->assertDatabaseHas('fornecedores', [
            'nome' => 'Fornecedor Teste',
            'cnpj_cpf' => '12345678000195', // Verifica se foi salvo sem caracteres especiais
        ]);
    }

    /** @test */
    public function nao_pode_cadastrar_fornecedor_com_cnpj_invalido()
    {
        $dados = [
            'nome' => 'Fornecedor Teste',
            'cnpj_cpf' => '00.000.000/0000-00', // CNPJ inválido
            'tipo_documento' => 'cnpj',
            'email' => 'fornecedor@example.com',
            'telefone' => '(11) 98765-4321',
            'rua' => 'Rua Teste',
            'numero' => '123',
            'bairro' => 'Centro',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01000-000',
        ];

        $response = $this->postJson('/api/fornecedores', $dados);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['cnpj_cpf']);
    }
}
