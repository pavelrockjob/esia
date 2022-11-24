<?php

namespace Pavelrockjob\Esia\Api;

use Illuminate\Support\Facades\Http;
use Pavelrockjob\Esia\Api\Models\EsiaDocs;
use Pavelrockjob\Esia\Api\Models\EsiaPersonal;
use Pavelrockjob\Esia\EsiaApi;

class EsiaPrns
{
    private $parent;
    private string $path = '/rs/prns/';
    private EsiaDocs $esiaDocs;

    public function __construct(EsiaApi $parent)
    {
        $this->parent = $parent;
        $this->esiaDocs = new EsiaDocs();
    }

    public function get(): EsiaPersonal
    {
        $endpoint = $this->getEndpoint('');

        return new EsiaPersonal($this->parent->authRequest()->get($endpoint)->json());
    }

    public function docs(): EsiaDocs
    {
        $endpoint = $this->getEndpoint('/docs');

        $response = $this->parent->authRequest()->get($endpoint)->json();

        if (!isset($response['elements'])) {
            throw new \Exception('Docs request error: elements is not set');
        }

        foreach ($response['elements'] as $element) {
            $this->esiaDocs->setDocument($this->getDoc($element));
        }

        return $this->esiaDocs;
    }

    //Получаем документы по одному
    private function getDoc($url): array
    {
        return $this->parent->authRequest()->get($url)->json();
    }

    private function getEndpoint(string $postfix): string
    {
        return $this->parent->getConfig()->getEsiaUrl() . $this->path . '/' . $this->parent->getProvider()->getOid() . '/' . $postfix;
    }


}
