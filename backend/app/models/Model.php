<?php

namespace App\models;

use Exception;

class Model
{

    protected static function loadTable($table_file)
    {
        $data = file_get_contents("./data/" . $table_file, 'r+');
        return $data;
    }

    protected static function updateTable($table_file, $data)
    {
        $fp = fopen("./data/" . $table_file, 'w');

        try {
            fwrite($fp, json_encode($data, JSON_UNESCAPED_UNICODE));
            fclose($fp);
            return 1;
        } catch (\Throwable $th) {
            throw new Exception(json_encode(["erro" => "Erro ao inserir dado!"]));
        }
    }
}
