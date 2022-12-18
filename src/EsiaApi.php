<?php

namespace Pavelrockjob\Esia;

use GuzzleHttp\Client;
use Pavelrockjob\Esia\Api\EsiaPrns;

class EsiaApi
{
    private EsiaConfig $esiaConfig;
    private EsiaProvider $esiaProvider;
    private EsiaPrns $esiaPrns;

    public Client $httpClient;

    public function __construct(EsiaConfig $esiaConfig, EsiaProvider $esiaProvider)
    {
        $this->esiaConfig = $esiaConfig;
        $this->esiaProvider = $esiaProvider;
        $this->esiaPrns = new EsiaPrns($this);


        $this->httpClient = new Client([
            'base_uri' => $this->esiaConfig->getEsiaUrl(),
            'timeout' => $this->esiaConfig->getHttpClientTimeOut(),
            'headers' => [
                'Authorization' => 'Bearer ' . $this->esiaProvider->getAccessToken()
            ]
        ]);

    }

    public function prns(): EsiaPrns
    {
        return $this->esiaPrns;
    }

    public function getConfig(): EsiaConfig
    {
        return $this->esiaConfig;
    }

    public function getProvider(): EsiaProvider
    {
        return $this->esiaProvider;
    }

    public function getEndpoint(string $path, string $postfix = ''): string
    {
        return  $path . '/' . $this->getProvider()->getOid() . '/' . $postfix;
    }

}
