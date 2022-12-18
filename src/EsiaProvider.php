<?php

namespace Pavelrockjob\Esia;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class EsiaProvider
{
    private EsiaConfig $config;
    private EsiaCryptoproSigner $signer;
    public EsiaApi $esiaApi;

    private string $state;
    private string $timestamp;

    //OID Пользователя
    private ?int $oid = null;
    //Учетная запись пользователя подтвержена
    private bool $isTrusted = false;
    //Тип субъекта
    private ?string $typ = null;

    private ?string $accessToken = null;
    private ?string $refreshToken = null;

    private Client $httpClient;

    /**
     * @param EsiaConfig $config
     * @throws Exception
     */
    public function __construct(EsiaConfig $config = new EsiaConfig([]))
    {
        $this->config = $config;
        $this->signer = new EsiaCryptoproSigner();

        $this->state = $this->seedState();
        $this->timestamp = $this->makeTimestamp();

        $this->httpClient = new Client([
            'base_uri' => $this->config->getEsiaUrl(),
            'timeout' => $this->config->getHttpClientTimeOut()
        ]);
    }

    /**
     * @throws Exception
     */
    public function getAuthLink(): string
    {

        $queryParams = [
            'client_id' => $this->config->getClientId(),
            'client_secret' => $this->signer->sign($this->makeSecret()),
            'redirect_uri' => $this->config->getRedirectUrl(),
            'scope' => $this->config->getScopesString(),
            'response_type' => $this->config->getResponseType(),
            'state' => $this->state,
            'timestamp' => $this->timestamp,
            'access_type' => $this->config->getAccessType()
        ];


        if ($this->config->isStateVerifyEnabled()) {
            if (!session_id()) {
                session_start();
            }

            $_SESSION['esia_state'] = $this->state;
        }


        return $this->config->getEsiaUrl() . "/aas/oauth2/ac?" . http_build_query($queryParams);
    }


    /**
     * @throws Exception
     */
    public function getToken(): void
    {

        if ($this->config->isStateVerifyEnabled()) {
            if (!session_id()) {
                @session_start();
            }

            if (!isset($_SESSION['esia_state'])) {
                throw new Exception('Session state is not present');
            }

            if ($_SESSION['esia_state'] !== $_REQUEST['state']) {
                throw new Exception('Unprocessable state value');
            }
        }


        if (empty($_REQUEST['code'])) {
            throw new Exception('Code is not present');
        }

        $queryParams = [
            'client_id' => $this->config->getClientId(),
            'code' => $_REQUEST['code'],
            'grant_type' => 'authorization_code',
            'client_secret' => $this->signer->sign($this->makeSecret()),
            'state' => $this->state,
            'redirect_uri' => $this->config->getRedirectUrl(),
            'scope' => $this->config->getScopesString(),
            'response_type' => $this->config->getResponseType(),
            'timestamp' => $this->timestamp,
            'token_type' => 'Bearer',
        ];


        $response = $this->httpClient->request('POST', "/aas/oauth2/te", [
            'form_params' => $queryParams
        ])->getBody();

        $json = json_decode($response, true);

        if (isset($json['error'])) {
            throw new Exception($json['error_description']);
        }

        $payload = $this->jwtDecode($json['id_token']);


        $this->oid = $payload['urn:esia:sbj']['urn:esia:sbj:oid'];
        $this->typ = $payload['urn:esia:sbj']['urn:esia:sbj:typ'];
        $this->isTrusted = isset($payload['urn:esia:sbj']['urn:esia:sbj:is_tru']);

        $this->accessToken = $json['access_token'];
        $this->refreshToken = $json['refresh_token'];

        $this->esiaApi = new EsiaApi($this->config, $this);

    }

    public function api(): EsiaApi
    {
        return $this->esiaApi;
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
        return $this->config->getScopesString() . $this->timestamp . $this->config->getClientId() . $this->state;
    }

    private function jwtDecode(string $token)
    {
        return json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $token)[1]))), true);
    }

    /**
     * @return string
     */
    public function getAccessToken(): ?string
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
    public function getRefreshToken(): ?string
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
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getTimestamp(): ?string
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
