<?php

namespace Pavelrockjob\Esia\Api\Models;

use Pavelrockjob\Esia\Api\Models\Docs\EsiaRfPassport;
use Pavelrockjob\Esia\Enums\Models\Docs\EsiaDocType;

class EsiaDocs
{
    private ?EsiaRfPassport $esiaRfPassport = null;

    public function setDocument(array $data){
        if (!isset($data['type'])){
            throw new \Exception('Doc type is not defined');
        }

        if (!in_array($data['type'], array_column(EsiaDocType::cases(), 'name'))){
            throw new \Exception('Doc type is not available.');
        }

        dump($data['type']);
        match ($data['type']){
            EsiaDocType::RF_PASSPORT->name => $this->esiaRfPassport = new EsiaRfPassport($data),
            //TODO OTHER DOCS
        };

        dd($this->esiaRfPassport);
    }

    public function getPassport(){
        return $this->esiaRfPassport;
    }
}
