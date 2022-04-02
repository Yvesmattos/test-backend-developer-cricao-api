<?php

namespace App\services;

use App\models\Beneficiario;
use App\models\Proposta;

class BeneficiarioService
{

    public function get($id)
    {
        if ($id) {
            return Beneficiario::getBeneficiarioData($id);
        } else {
            return Beneficiario::getAllBeneficiarioData();
        }
    }
    public function post($request)
    {
        $response = Beneficiario::insert($request);
        if (is_numeric($response[0])) {
            Proposta::insertProposta($response[1]);
            http_response_code(200);
            return json_encode(["sucesso" => "Inclusão bem-sucedida. Registro $response[0]"], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(500);
            return json_encode(["erro" => "$response"], JSON_UNESCAPED_UNICODE);
        }
    }
}
