<?php

namespace Pavelrockjob\Esia;

use GuzzleHttp\Client;
use Pavelrockjob\Esia\Exceptions\EsiaSignerException;

class EsiaCryptoproSigner
{
    protected string $serviceUrl;
    protected string $client;
    protected string $secret;
    protected string $string;

    protected Client $httpClient;


    public function __construct()
    {
        $this->serviceUrl = config('esia.signer.url');
        $this->client = config('esia.signer.client');
        $this->secret = config('esia.signer.secret');

        $this->httpClient = new Client([
            'base_uri' => $this->serviceUrl,
            'timeout' => 5,
        ]);
    }

    /**
     * @throws \Exception
     */
    public function sign(string $string): string
    {
        $this->string = $string;
        return $this->makeRequest();

    }

    /**
     * @throws \Exception
     */
    private function makeRequest(): string
    {
        $formParams = [
            'client' => $this->client,
            'secret' => $this->secret,
            'string' => $this->string
        ];

        $response = $this->httpClient->request('POST', "/aas/oauth2/te", [
            'form_params' => $formParams
        ])->getBody();

        $json = json_decode($response, true);

        if ($json['status'] != 'ok') {
            throw new EsiaSignerException('Signer response status not ok');
        }

        if (empty($json['signedContent'])) {
            throw new EsiaSignerException('Signed content is empty');
        }

        return trim($json['signedContent']);

    }


}
