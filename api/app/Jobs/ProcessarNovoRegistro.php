<?php

namespace App\Jobs;

use App\Services\CnpjService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessarNovoRegistro implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    /**
     * Instância do fornecedor.
     *
     * @var \App\Models\Fornecedor
     */
    protected $fornecedor;

    /**
     * Cria uma nova instância do job.
     *
     * @param  \App\Models\Fornecedor  $fornecedor
     * @return void
     */
    public function __construct($fornecedor)
    {
        $this->fornecedor = $fornecedor;
    }

    /**
     * Executa o job.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            // Consulta o CNPJ e decodifica o resultado
            $resultado = CnpjService::consultarCnpj($this->fornecedor->cnpj_cpf);
            $resultado = json_decode($resultado);

            // Atualiza a observação com base no resultado da consulta
            if (isset($resultado->estabelecimento->motivo_situacao_cadastral->descricao)) {
                $this->fornecedor->observacoes = $resultado->estabelecimento->motivo_situacao_cadastral->descricao;
            } else {
                $this->fornecedor->observacoes = "É uma empresa em situação regular";
            }

            // Persiste a alteração no banco de dados
            $this->fornecedor->save();
        } catch (\Exception $e) {
            // Loga o erro para futura análise e permite que o job falhe, 
            // podendo ser reprocessado se necessário.
            Log::error('Erro ao processar novo registro no job ProcessarNovoRegistro: ' . $e->getMessage());
            // Opcionalmente, você pode relançar a exceção para que o job seja reprocessado.
            throw $e;
        }
    }
}
