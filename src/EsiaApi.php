<?php

namespace Pavelrockjob\Esia;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Pavelrockjob\Esia\Api\EsiaPrns;

class EsiaApi
{
    private EsiaConfig $esiaConfig;
    private EsiaProvider $esiaProvider;
    private EsiaPrns $esiaPrns;

    public function __construct(EsiaConfig $esiaConfig, EsiaProvider $esiaProvider)
    {
        $this->esiaConfig = $esiaConfig;
        $this->esiaProvider = $esiaProvider;
        $this->esiaPrns = new EsiaPrns($this);
    }

    public function prns(): EsiaPrns
    {
        return $this->esiaPrns;
    }

    public function authRequest(): PendingRequest
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->esiaProvider->getAccessToken()
        ]);
    }

    public function getConfig(): EsiaConfig
    {
        return $this->esiaConfig;
    }

    public function getProvider(): EsiaProvider
    {
        return $this->esiaProvider;
    }

}
