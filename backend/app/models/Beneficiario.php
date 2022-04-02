<?php

namespace App\models;

use App\models\Model;

class Beneficiario extends Model
{

    private static $table_file = 'beneficiarios.json';



    public static function getBeneficiarioData(int $id)
    {
        $beneficiarios = self::loadTable(self::$table_file);

        foreach (json_decode($beneficiarios, true) as $beneficiario) {

            if ($beneficiario['reg_beneficiario'] === $id) {
                return json_encode($beneficiario);
            }
        }
        http_response_code(404);
        return json_encode(["erro" => "Beneficiário não encontrado"], JSON_UNESCAPED_UNICODE);
    }
    public static function getAllBeneficiarioData()
    {
        $beneficiarios = self::loadTable(self::$table_file);
        return $beneficiarios;
    }

    public static function insert($data)
    {
        $beneficiarios_cadastrados = json_decode(self::loadTable(self::$table_file)) !== null ? json_decode(self::loadTable(self::$table_file)) : [];
        $arr_ids = $beneficiarios_cadastrados !== null ? array_column($beneficiarios_cadastrados, 'reg_beneficiario') : [];
        $plan_exists = self::validarPlanoInformado($data);

        if ($plan_exists === true) {
            rsort($arr_ids);
            $reg_beneficiario_id = $arr_ids[0] !== null && $arr_ids[0] ? $arr_ids[0] + 1 : 1;
            $data['reg_beneficiario'] = $reg_beneficiario_id;
            krsort($data);
            array_push($beneficiarios_cadastrados, $data);

            try {
                self::updateTable(self::$table_file, $beneficiarios_cadastrados);
                return [$reg_beneficiario_id, $data];
            } catch (\Throwable $th) {
                echo $th;
            }
        } else {
            $response = $plan_exists;
            return $response;
        }
    }

    private static function validarPlanoInformado($request)
    {
        $planos_disponiveis = json_decode(Plano::loadTable(('plans.json')));
        $plans = array_column($planos_disponiveis, 'registro');
        $request_planos = $request['beneficiarios'];
        $beneficiarios_name = array();
        foreach ($request_planos as $req) {
            if (!in_array($req['reg_plan'], $plans)) {
                array_push($beneficiarios_name, $req['nome']);
            }
        }
        if (sizeof($beneficiarios_name) > 0) {
            return "O código do plano é inválido para os beneficiários " . implode(",", $beneficiarios_name);
        }
        return true;
    }
}
