<?php

namespace App\models;

class Plano extends Model
{
    private static $table_file = 'plans.json';


    public static function getPlanByReg($reg_plan)
    {
        $planos = json_decode(self::loadTable(self::$table_file), true);

        foreach ($planos as $e_plano) {
            if ($e_plano['registro'] == $reg_plan) {
                return $e_plano;
            }
        }
    }
}
