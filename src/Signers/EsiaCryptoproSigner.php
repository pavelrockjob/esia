<?php

/**
 * Реализация получиения подписи с алгоритмами
 * формирования электронной подписи ГОСТ Р 34.10-2012 и криптографического
 * хэширования ГОСТ Р 34.11-2012 через cryptopro контейнер
 */

namespace Pavelrockjob\Esia\Signers;

use GuzzleHttp\Client;

class EsiaCryptoproSigner extends EsiaSigner
{
    private string $serviceUrl = '';
    private string $client = '';
    private string $secret = '';
    private string $string = '';

    private Client $httpClient;

    public function __construct(array $config = [])
    {
        if (function_exists('config')){
            $this->serviceUrl = config('esia.signer.url');
            $this->client = config('esia.signer.client');
            $this->secret = config('esia.signer.secret');
        }

        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

        $this->httpClient = new Client([
            'base_uri' => $this->serviceUrl,
            'timeout' => 5.0,
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
        try {

            $params = [
                'client' => $this->client,
                'secret' => $this->secret,
                'string' => $this->string
            ];

            $response = $this->httpClient->request('POST', "", [
                'form_params' => $params
            ])->getBody();

            $json = json_decode($response, true);

            if ($json['status'] != 'ok') {
                throw new \Exception('Signer response status not ok');
            }

            if (empty($json['signedContent'])) {
                throw new \Exception('Signed content is empty');
            }

            return trim($json['signedContent']);

        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }


}
