<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
use App\services\BeneficiarioService;
use App\services\PropostaService;

require __DIR__ . '/vendor/autoload.php';

if ($_SERVER['REQUEST_URI']) {
    $url = explode('/', $_SERVER['REQUEST_URI']);

    if ($url[1] === 'api') {
        $api = $url[2];
        switch ($api) {
            case 'beneficiarios':
                if ($_SERVER["REQUEST_METHOD"] === 'GET') {
                    $beneficiario_id = $url[3];
                    $response = call_user_func_array(array(new BeneficiarioService, 'get'), array($beneficiario_id));
                    echo $response;
                } else if($_SERVER["REQUEST_METHOD"] === 'POST') {
                    $request = json_decode(file_get_contents("php://input"), true);
                    
                    $response = call_user_func_array(array(new BeneficiarioService, 'post'), array($request));
                    echo $response;
                    exit;
                }
                break;
            case 'propostas':
                if ($_SERVER["REQUEST_METHOD"] === 'GET') {
                    $beneficiario_id = $url[3];
                    $response = call_user_func_array(array(new PropostaService, 'get'), array($proposta_id));
                    echo $response;
                }
                break;
            default:
                http_response_code(404);
                echo json_encode(["erro_msg" => "Esta api não existe!"], JSON_UNESCAPED_UNICODE);
                break;
        }
    } else {
        http_response_code(404);
        echo json_encode(['erro' => 'Api não encontrada'], JSON_UNESCAPED_UNICODE);
    }
}
