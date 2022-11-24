<?php

namespace Pavelrockjob\Esia;

use Pavelrockjob\Esia\Api\EsiaPersonal;
use Illuminate\Support\Facades\Http;

class EsiaApi
{
    private string $path = '/rs/prns/';
    private EsiaConfig $esiaConfig;
    private EsiaProvider $esiaProvider;

    public function __construct(EsiaConfig $esiaConfig, EsiaProvider $esiaProvider)
    {
        $this->esiaConfig = $esiaConfig;
        $this->esiaProvider = $esiaProvider;
    }

    public function prns(): EsiaPersonal
    {
        $endpoint = $this->getEndpoint('');

        $request = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->esiaProvider->getAccessToken()
        ])->get($endpoint);

        return new EsiaPersonal($request->body());
    }

    private function getEndpoint(string $postfix): string
    {
        return $this->esiaConfig->esiaUrl.$this->path.'/'.$this->esiaProvider->getOid().'/'.$postfix;
    }
}
