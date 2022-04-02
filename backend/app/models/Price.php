<?php

namespace App\models;

class Price extends Model
{

    private static $table_file = 'prices.json';

    public static function getPricesByCod($codigo, $quantidade_integrantes_plano)
    {
        $prices = json_decode(self::loadTable(self::$table_file), true);
        $possible_prices = [];

        // print_r($codigo);

        foreach ($prices as $e_prices) {
            if ($e_prices['codigo'] == $codigo) {
                if ($codigo !== 1 && $codigo !== 6) {
                    return $e_prices;
                }
                array_push($possible_prices, $e_prices);
            }
        }

        $price = (array_filter($possible_prices, function ($possible_prices) use ($quantidade_integrantes_plano) {
            return $possible_prices['minimo_vidas'] <= $quantidade_integrantes_plano;
        }));

        return $price[sizeof($price) - 1];
    }
}
