<?php

namespace Pavelrockjob\Esia\Api\Models\Docs;

class EsiaMedicalPolicy extends EsiaDoc
{
    protected ?string $medicalOrg = null;
    protected ?string $omsNumber = null;
    protected ?string $unitedNumber = null;

    /**
     * @return string|null
     */
    public function getMedicalOrg(): ?string
    {
        return $this->medicalOrg;
    }

    /**
     * @return string|null
     */
    public function getOmsNumber(): ?string
    {
        return $this->omsNumber;
    }

    /**
     * @return string|null
     */
    public function getUnitedNumber(): ?string
    {
        return $this->unitedNumber;
    }


}
