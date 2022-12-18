<?php

namespace Pavelrockjob\Esia\Api;

use Illuminate\Support\Facades\Http;
use Pavelrockjob\Esia\Api\Models\EsiaContacts;
use Pavelrockjob\Esia\Api\Models\EsiaDocs;
use Pavelrockjob\Esia\Api\Models\EsiaPersonal;
use Pavelrockjob\Esia\EsiaApi;
use Pavelrockjob\Esia\EsiaConfig;
use Pavelrockjob\Esia\EsiaProvider;

class EsiaPrns
{
    private string $path = '/rs/prns/';

    private EsiaApi $esiaApi;
    private EsiaDocs $esiaDocs;
    private EsiaContacts $esiaContacts;

    public function __construct(EsiaApi $esiaApi)
    {
        $this->esiaApi = $esiaApi;

        $this->esiaDocs = new EsiaDocs($this->esiaApi, $this->path);
        $this->esiaContacts = new EsiaContacts($this->esiaApi, $this->path);
    }

    public function get(): EsiaPersonal
    {

        $endpoint = $this->esiaApi->getEndpoint($this->path);

        $response = $this->esiaApi->httpClient->request('GET', $endpoint)->getBody();

        $json = json_decode($response, true);

        return new EsiaPersonal($json);
    }

    public function docs(): EsiaDocs
    {
        return $this->esiaDocs;
    }

    public function ctts(): EsiaContacts
    {
        /*
        $endpoint = $this->getEndpoint('/ctts');

        $response = $this->esiaApi->authRequest()->get($endpoint)->json();

        if (!isset($response['elements'])) {
            throw new \Exception('Contacts request error: elements is not set.');
        }

        foreach ($response['elements'] as $element){
            $this->esiaContacts->setContact($this->getContact($element));
        }
        */

        return $this->esiaContacts;
    }

    /*
    private function getContact($url): array
    {
        return $this->esiaApi->authRequest()->get($url)->json();
    }

    //Получаем документы по одному
    private function getDoc($url): array
    {
        return $this->esiaApi->authRequest()->get($url)->json();
    }
    */


}
