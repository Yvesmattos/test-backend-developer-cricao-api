<?php

namespace App\models;

class Proposta extends Model
{

    private static $table_file = 'propostas.json';


    public static function getPropostaData(int $id)
    {
        $propostas = self::loadTable(self::$table_file);

        foreach (json_decode($propostas, true) as $proposta) {

            if ($proposta['proposta_id'] === $id) {
                return json_encode($proposta);
            }
        }
        
        http_response_code(404);
        return json_encode(["erro" => "Beneficiário não encontrado"], JSON_UNESCAPED_UNICODE);
    }
    public static function getAllPropostaData()
    {
        $propostas = self::loadTable(self::$table_file);
        return $propostas;
    }

    public static function insertProposta($data)
    {
        $data_proposta = self::createProposta($data);

        $propostas_cadastradas = json_decode(self::loadTable(self::$table_file)) !== null ? json_decode(self::loadTable(self::$table_file)) : [];
        $arr_ids = $propostas_cadastradas !== null ? array_column($propostas_cadastradas, 'proposta_id') : [];

        rsort($arr_ids, '2');
        $proposta_id = $arr_ids[0] !== null ? $arr_ids[0] + 1 : 1;
        $data_proposta['proposta_id'] = $proposta_id;
        krsort($data_proposta);
        array_push($propostas_cadastradas, $data_proposta);

        try {
            self::updateTable(self::$table_file, $propostas_cadastradas);
            return [$proposta_id, $data_proposta];
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    private static function createProposta($data)
    {
        // print_r($data);
        $beneficiarios = $data['beneficiarios'];
        $beneficiarios_proposta = array("quantidade" =>$data['quantidade']);
        $total_price = 0.0;
        $array_aux = [];
        foreach ($beneficiarios as $beneficiario) {
            $quantidade_participantes_planos = sizeof(array_filter($beneficiarios, function ($beneficiarios) use ($beneficiario) {
                return $beneficiarios['reg_plan'] === $beneficiario['reg_plan'];
            }));

            $beneficiario_individual_proposta = self::calcPlan($beneficiario, $quantidade_participantes_planos);
            $total_price += $beneficiario_individual_proposta['valor_plano'];
            array_push($array_aux, $beneficiario_individual_proposta);
            $beneficiarios_proposta['beneficiarios'] = $array_aux;
        }
        $beneficiarios_proposta['valor_total'] = $total_price;
        return $beneficiarios_proposta;
    }
    private static function calcPlan($dt, $quantidade_participantes_planos)
    {
        $plano = Plano::getPlanByReg($dt['reg_plan']);
        $price = Price::getPricesByCod($plano['codigo'], $quantidade_participantes_planos);
        $idade = $dt['idade'];
        $faixa = "";

        if ($idade > 0 && $idade <= 17)
            $faixa = "faixa1";
        else if ($idade <= 40) {
            $faixa = "faixa2";
        } else {
            $faixa = "faixa3";
        }

        $dt['nome_plano'] = $plano['nome'];
        $dt['codigo_plano'] = $plano['codigo'];
        $dt['valor_plano'] = $price[$faixa];
        return $dt;
    }
}
