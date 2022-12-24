<?php

namespace Pavelrockjob\Esia\Api\Models;

use Pavelrockjob\Esia\Api\Models\Contacts\EsiaEmail;
use Pavelrockjob\Esia\Api\Models\Contacts\EsiaMobilePhone;
use Pavelrockjob\Esia\Api\Models\Contacts\EsiaPhone;
use Pavelrockjob\Esia\Api\Models\Docs\EsiaDrivingLicence;
use Pavelrockjob\Esia\Api\Models\Docs\EsiaForeignBirthCertificate;
use Pavelrockjob\Esia\Api\Models\Docs\EsiaForeignDocument;
use Pavelrockjob\Esia\Api\Models\Docs\EsiaForeignPassport;
use Pavelrockjob\Esia\Api\Models\Docs\EsiaMedicalPolicy;
use Pavelrockjob\Esia\Api\Models\Docs\EsiaMilitaryId;
use Pavelrockjob\Esia\Api\Models\Docs\EsiaOldBirthCertificate;
use Pavelrockjob\Esia\Api\Models\Docs\EsiaRfBirthCertificate;
use Pavelrockjob\Esia\Api\Models\Docs\EsiaRfPassport;
use Pavelrockjob\Esia\Enums\Models\Contacts\EsiaContactType;
use Pavelrockjob\Esia\Enums\Models\Docs\EsiaDocType;
use Pavelrockjob\Esia\EsiaApi;

class EsiaElement
{
    protected string $url;
    protected array $rawData = [];

    protected EsiaApi $esiaApi;

    public function __construct(EsiaApi $esiaApi,string $url)
    {
        $this->esiaApi = $esiaApi;
        $this->setUrl($url);
    }


    /**
     * @return array
     */
    public function getRawData(): array
    {
        return $this->rawData;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }


    public function get()
    {
        $response = $this->esiaApi->httpClient->request('GET', $this->url)->getBody();
        $this->rawData =  json_decode($response, true);


        if (!isset($this->rawData['type'])){
            throw new \Exception('Element type is not defined');
        }

        $availableTypes = array_merge( array_column(EsiaDocType::cases(), 'name'),
                                       array_column(EsiaContactType::cases(), 'name'));

        if (!in_array($this->rawData['type'], $availableTypes)){
            throw new \Exception('Element type is not available.');
        }


        return match ($this->rawData['type']){
            //DOCS
            EsiaDocType::RF_PASSPORT->name => new EsiaRfPassport($this->rawData),
            EsiaDocType::FID_DOC->name => new EsiaForeignDocument($this->rawData),
            EsiaDocType::RF_DRIVING_LICENSE->name => new EsiaDrivingLicence($this->rawData),
            EsiaDocType::MLTR_ID->name =>  new EsiaMilitaryId($this->rawData),
            EsiaDocType::FRGN_PASS =>  new EsiaForeignPassport($this->rawData),
            EsiaDocType::MDCL_PLCY => new EsiaMedicalPolicy($this->rawData),
            EsiaDocType::RF_BRTH_CERT => new EsiaRfBirthCertificate($this->rawData),
            EsiaDocType::FID_BRTH_CERT => new EsiaForeignBirthCertificate($this->rawData),
            EsiaDocType::OLD_BRTH_CERT => new EsiaOldBirthCertificate($this->rawData),

            //CONTACTS
            EsiaContactType::MBT->name => new EsiaMobilePhone($this->rawData),
            EsiaContactType::EML->name => new EsiaEmail($this->rawData),
            EsiaContactType::PHN->name => new EsiaPhone($this->rawData),
        };
    }

}
