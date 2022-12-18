<?php

namespace Pavelrockjob\Esia\Api\Models\Docs;

class EsiaRfBirthCertificate extends EsiaDoc
{
    protected ?string $actDate = null;

    /**
     * @return string|null
     */
    public function getActDate(): ?string
    {
        return $this->actDate;
    }
}
