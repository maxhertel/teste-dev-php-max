<?php 
namespace App\Services;

/**
 * @OA\Ignore
 */
class CnpjService{
    protected const API_URL = 'https://comercial.cnpj.ws/cnpj/';
    protected const TOKEN = 'woAEA2TVbBAiIRLv1EDcCuacdx79pslkEoEafUIXO1JE';

    public static function consultarCnpj($cnpj) {
        $url = self::API_URL . $cnpj;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'x_api_token: ' .self::TOKEN,
        ]);

        $response = curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        return $response;
    }

    public static function consultarBrasilCnpj($cnpj) {
        $url = "https://brasilapi.com.br/api/cnpj/v1/" . $cnpj;
    
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
        $response = curl_exec($curl);
        $error = curl_error($curl);
    
        curl_close($curl);
    
        if ($error) {
            return ['error' => 'Erro ao consultar API: ' . $error];
        }
    
        return json_decode($response, true);
    }
    
}