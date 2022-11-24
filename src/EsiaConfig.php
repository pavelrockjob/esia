<?php

namespace Pavelrockjob\Esia;

use Pavelrockjob\Esia\Enums\EsiaScope;

class EsiaConfig
{

    private ?string $esiaUrl = null;
    private ?string $clientId = null;
    private ?string $redirectUrl = null;
    private array $scopes = [EsiaScope::fullname, EsiaScope::email, EsiaScope::openid];
    private string $responseType = 'code';
    private string $accessType = 'online';

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->esiaUrl = config('esia.esia_url');
        $this->clientId = config('esia.client_id');
        $this->redirectUrl = config('esia.redirect_url');

        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

    }

    public function getScopesString(): string{
        $scopes = [];
        foreach ($this->scopes as $scope){
            $scopes[] = $scope->name;
        }
        return implode(' ', $scopes);
    }
    
    /**
     * @return string|null
     */
    public function getEsiaUrl(): ?string
    {
        return $this->esiaUrl;
    }

    /**
     * @param string|null $esiaUrl
     */
    public function setEsiaUrl(?string $esiaUrl): void
    {
        $this->esiaUrl = $esiaUrl;
    }

    /**
     * @return string|null
     */
    public function getClientId(): ?string
    {
        return $this->clientId;
    }

    /**
     * @param string|null $clientId
     */
    public function setClientId(?string $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string|null
     */
    public function getRedirectUrl(): ?string
    {
        return $this->redirectUrl;
    }

    /**
     * @param string|null $redirectUrl
     */
    public function setRedirectUrl(?string $redirectUrl): void
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return array
     */
    public function getScopes(): array
    {
        return $this->scopes;
    }

    /**
     * @param array $scopes
     */
    public function setScopes(array $scopes): void
    {
        $this->scopes = $scopes;
    }

    /**
     * @return string
     */
    public function getResponseType(): string
    {
        return $this->responseType;
    }

    /**
     * @param string $responseType
     */
    public function setResponseType(string $responseType): void
    {
        $this->responseType = $responseType;
    }

    /**
     * @return string
     */
    public function getAccessType(): string
    {
        return $this->accessType;
    }

    /**
     * @param string $accessType
     */
    public function setAccessType(string $accessType): void
    {
        $this->accessType = $accessType;
    }

   


}
