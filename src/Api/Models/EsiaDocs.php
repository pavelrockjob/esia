<?php

namespace Pavelrockjob\Esia\Api\Models;

use Pavelrockjob\Esia\Api\Models\Abstract\EsiaElementsModel;
use Pavelrockjob\Esia\Api\Models\Docs\EsiaForeignBirthCertificate;
use Pavelrockjob\Esia\Api\Models\Docs\EsiaOldBirthCertificate;
use Pavelrockjob\Esia\Api\Models\Docs\EsiaRfBirthCertificate;
use Pavelrockjob\Esia\Api\Models\Docs\EsiaDrivingLicence;
use Pavelrockjob\Esia\Api\Models\Docs\EsiaForeignDocument;
use Pavelrockjob\Esia\Api\Models\Docs\EsiaForeignPassport;
use Pavelrockjob\Esia\Api\Models\Docs\EsiaMedicalPolicy;
use Pavelrockjob\Esia\Api\Models\Docs\EsiaMilitaryId;
use Pavelrockjob\Esia\Api\Models\Docs\EsiaRfPassport;
use Pavelrockjob\Esia\Enums\Models\Docs\EsiaDocType;

class EsiaDocs extends EsiaElementsModel
{
    protected string $postfix = 'docs';

    /**
     * @return EsiaRfPassport|null
     * @throws \Exception
     */
    public function getRfPassport(): ?EsiaRfPassport
    {
        return $this->findElement(EsiaDocType::RF_PASSPORT->name);
    }

    /**
     * @return EsiaForeignDocument|null
     * @throws \Exception
     */
    public function getForeignDocument(): ?EsiaForeignDocument
    {
        return $this->findElement(EsiaDocType::FID_DOC->name);
    }

    /**
     * @return EsiaDrivingLicence|null
     * @throws \Exception
     */
    public function getDrivingLicence(): ?EsiaDrivingLicence
    {
        return $this->findElement(EsiaDocType::RF_DRIVING_LICENSE->name);
    }

    /**
     * @return EsiaMilitaryId|null
     * @throws \Exception
     */
    public function getMilitaryId(): ?EsiaMilitaryId
    {
        return $this->findElement(EsiaDocType::MLTR_ID->name);
    }

    /**
     * @return EsiaForeignPassport|null
     * @throws \Exception
     */
    public function getForeignPassport(): ?EsiaForeignPassport
    {
        return $this->findElement(EsiaDocType::FRGN_PASS->name);
    }

    /**
     * @return EsiaMedicalPolicy|null
     * @throws \Exception
     */
    public function getMedicalPolicy(): ?EsiaMedicalPolicy
    {
        return $this->findElement(EsiaDocType::MDCL_PLCY->name);
    }

    /**
     * @return EsiaRfBirthCertificate|null
     * @throws \Exception
     */
    public function getRfBirthCertificate(): ?EsiaRfBirthCertificate
    {
        return $this->findElement(EsiaDocType::RF_BRTH_CERT->name);
    }

    /**
     * @return EsiaForeignBirthCertificate|null
     * @throws \Exception
     */
    public function getForeignBirthCertificate(): ?EsiaForeignBirthCertificate
    {
        return $this->findElement(EsiaDocType::FID_BRTH_CERT->name);
    }

    /**
     * @return EsiaOldBirthCertificate|null
     * @throws \Exception
     */
    public function getOldBirthCertificate(): ?EsiaOldBirthCertificate
    {
        return $this->findElement(EsiaDocType::OLD_BRTH_CERT->name);
    }


}
