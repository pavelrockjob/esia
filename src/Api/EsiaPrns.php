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

    public function __construct(EsiaApi $esiaApi)
    {
        $this->esiaApi = $esiaApi;

        $this->esiaDocs = new EsiaDocs($this->esiaApi, $this->path);
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

}
