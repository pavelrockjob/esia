<?php

namespace Pavelrockjob\Esia;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class EsiaProvider
{
    private EsiaConfig $config;
    private EsiaCryptoproSigner $signer;
    public EsiaApi $api;

    private string $state;
    private string $timestamp;

    //OID Пользователя
    private int|null $oid = null;
    //Учетная запись пользователя подтвержена
    private bool $isTrusted = false;
    //Тип субъекта
    private string|null $typ = null;

    private string $accessToken;
    private string $refreshToken;


    /**
     * @param EsiaConfig $config
     * @throws Exception
     */
    public function __construct(EsiaConfig $config = new EsiaConfig([]))
    {
        $this->config = $config;
        $this->signer = new EsiaCryptoproSigner(
            'http://cryptopro:8181/signer.php',
                     'developer',
            'dSf1rHOsQmOrR8lrIApsrmO9Hn89n55scrtnhONGZhCCNecF3m25xmapXmJciffuM7yRfhnPSVHFGb0u',
        );

        $this->state = $this->seedState();
        $this->timestamp = $this->makeTimestamp();

        $this->api = new EsiaApi($this->config, $this);
    }

    /**
     * @throws Exception
     */
    public function getAuthLink(): string
    {

        $queryParams = [
            'client_id' => $this->config->clientId,
            'client_secret' => $this->signer->sign($this->makeSecret()),
            'redirect_uri' => $this->config->redirectUri,
            'scope' => $this->config->getScopesString(),
            'response_type' => $this->config->responseType,
            'state' => $this->state,
            'timestamp' => $this->timestamp,
            'access_type' => $this->config->accessType
        ];

        Session::put('state', $this->state);
        Session::save();


        return $this->config->esiaUrl . "/aas/oauth2/ac?" . http_build_query($queryParams);
    }


    /**
     * @throws Exception
     */
    public function getToken(): void{
        if (!Session::has('state')){
            throw new Exception('State is not present');
        }

        if (Session::get('state') !== request()->get('state')){
            throw new Exception('Unprocessable state value');
        }

        if (!request()->has('code')){
            throw new Exception('Code is not present');
        }

        $queryParams = [
            'client_id' => $this->config->clientId,
            'code' => request()->get('code'),
            'grant_type' => 'authorization_code',
            'client_secret' => $this->signer->sign($this->makeSecret()),
            'state' => $this->state,
            'redirect_uri' => $this->config->redirectUri,
            'scope' => $this->config->getScopesString(),
            'response_type' => $this->config->responseType,
            'timestamp' => $this->timestamp,
            'token_type' => 'Bearer',
        ];


        $response = Http::asForm()->post($this->config->esiaUrl.'/aas/oauth2/te', $queryParams)->json();

        if (isset($response['error'])){
            throw new Exception($response['error_description']);
        }

        $payload = $this->jwtDecode($response['id_token']);


        $this->oid = $payload['urn:esia:sbj']['urn:esia:sbj:oid'];
        $this->typ = $payload['urn:esia:sbj']['urn:esia:sbj:typ'];
        $this->isTrusted = isset($payload['urn:esia:sbj']['urn:esia:sbj:is_tru']);

        $this->accessToken = $response['access_token'];
        $this->refreshToken = $response['refresh_token'];

    }

    private function makeTimestamp(): string
    {
        return date('Y.m.d H:i:s O');
    }

    /**
     * @throws Exception
     */
    private function seedState(): string
    {
        try {
            return sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                random_int(0, 0xffff),
                random_int(0, 0xffff),
                random_int(0, 0xffff),
                random_int(0, 0x0fff) | 0x4000,
                random_int(0, 0x3fff) | 0x8000,
                random_int(0, 0xffff),
                random_int(0, 0xffff),
                random_int(0, 0xffff)
            );
        } catch (Exception $e) {
            throw new Exception('Cannot generate random integer', $e);
        }
    }

    private function makeSecret(): string
    {
        return $this->config->getScopesString().$this->timestamp.$this->config->clientId.$this->state;
    }

    private function jwtDecode(string $token)
    {
        return json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $token)[1]))), true);
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * @param string $refreshToken
     */
    public function setRefreshToken(string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    /**
     * @return int|null
     */
    public function getOid(): ?int
    {
        return $this->oid;
    }

    /**
     * @return bool
     */
    public function isTrusted(): bool
    {
        return $this->isTrusted;
    }

    /**
     * @return string|null
     */
    public function getTyp(): ?string
    {
        return $this->typ;
    }


}
