<?php

namespace Pavelrockjob\Esia;

use Pavelrockjob\Esia\Enums\EsiaScope;

class EsiaConfig
{

    public string $esiaUrl = 'https://esia-portal1.test.gosuslugi.ru';
    public string $clientId = '03YI05';
    public string $redirectUri = 'http://127.0.0.1:8080/auth/esia/callback';
    public array $scopes = [EsiaScope::fullname, EsiaScope::email, EsiaScope::openid];
    public string $responseType = 'code';
    public string $accessType = 'online';

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
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
