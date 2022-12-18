<?php

namespace Pavelrockjob\Esia\Api\Models\Contacts;

use Pavelrockjob\Esia\Api\Models\Abstract\EsiaModel;

class EsiaContact extends EsiaModel
{
    protected ?string $type = null;
    protected ?string $vrfStu = null;
    protected ?string $value = null;
    protected ?string $vrfValStu = null;
    protected ?string $verifyingValue = null;
}
