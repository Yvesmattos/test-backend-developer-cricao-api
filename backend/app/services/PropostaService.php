<?php

namespace App\services;

use App\models\Proposta;

class PropostaService
{

    public function get($id)
    {
        if ($id) {
            return Proposta::getPropostaData($id);
        } else {
            return Proposta::getAllPropostaData();
        }
    }
}
