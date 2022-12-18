<?php

namespace Pavelrockjob\Esia\Api\Models\Docs;

class EsiaOldBirthCertificate extends EsiaDoc
{
    protected ?string $actNo = null;

    /**
     * @return string|null
     */
    public function getActNo(): ?string
    {
        return $this->actNo;
    }
}
