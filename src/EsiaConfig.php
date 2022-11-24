<?php

namespace Pavelrockjob\Esia;

use Pavelrockjob\Esia\Enums\EsiaScope;

class EsiaConfig
{

    public ?string $esiaUrl = null;
    public ?string $clientId = null;
    public ?string $redirectUrl = null;
    public array $scopes = [EsiaScope::fullname, EsiaScope::email, EsiaScope::openid];
    public string $responseType = 'code';
    public string $accessType = 'online';

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


}
