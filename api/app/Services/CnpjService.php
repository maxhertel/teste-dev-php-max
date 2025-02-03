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
}