<?php

namespace Pavelrockjob\Esia\Api\Models\Docs;

class EsiaForeignPassport extends EsiaDoc
{
    protected ?string $lastName = null;
    protected ?string $firstName = null;

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }


}
