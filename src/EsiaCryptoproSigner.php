<?php

namespace Pavelrockjob\Esia;

use Illuminate\Support\Facades\Http;

class EsiaCryptoproSigner
{
    private string $serviceUrl;
    private string $client;
    private string $secret;
    private string $string;

    public function __construct()
    {
        $this->serviceUrl = config('esia.signer.url');
        $this->client = config('esia.signer.client');
        $this->secret = config('esia.signer.secret');
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
    private function makeRequest(): string{
        try {

            $response = json_decode(Http::get($this->serviceUrl, [
                'client' => $this->client,
                'secret' => $this->secret,
                'string' => $this->string
            ])->body());

            if ($response->status != 'ok'){
                throw new \Exception('Signer response status not ok');
            }

            if (empty($response->signedContent)){
                throw new \Exception('Signed content is empty');
            }

            return trim($response->signedContent);

        } catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }


}
