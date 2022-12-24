<?php
namespace Pavelrockjob\Esia\Api;

class EsiaPersonal
{
    protected ?string $firstName = null;
    protected ?string $lastName = null;
    protected ?string $middleName = null;

    //тип учетной записи (подтверждена («true») / не подтверждена(«false»));
    protected ?bool $trusted = null;
    protected ?int $updatedOn = null;
    protected ?bool $rfgUOperatorCheck = null;
    protected ?string $status = null;
    protected ?bool $verifying = null;
    //идентификатор текущего документа пользователя
    protected ?int $rIdDoc = null;
    protected ?bool $containsUpCfmCode = null;
    protected ?string $eTag = null;
    protected ?string $gender = null;
    protected ?string $citizenship = null;
    protected ?string $snils = null;
    protected ?string $inn = null;
    //информация о самозанятом
    protected ?string $selfEmployed = null;

    public function __construct(string $data)
    {
        $data = json_decode($data, true);
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

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
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    /**
     * @return bool|null
     */
    public function getTrusted(): ?bool
    {
        return $this->trusted;
    }

    /**
     * @return int|null
     */
    public function getUpdatedOn(): ?int
    {
        return $this->updatedOn;
    }

    /**
     * @return bool|null
     */
    public function getRfgUOperatorCheck(): ?bool
    {
        return $this->rfgUOperatorCheck;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @return bool|null
     */
    public function getVerifying(): ?bool
    {
        return $this->verifying;
    }

    /**
     * @return int|null
     */
    public function getRIdDoc(): ?int
    {
        return $this->rIdDoc;
    }

    /**
     * @return bool|null
     */
    public function getContainsUpCfmCode(): ?bool
    {
        return $this->containsUpCfmCode;
    }

    /**
     * @return string|null
     */
    public function getETag(): ?string
    {
        return $this->eTag;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @return string|null
     */
    public function getCitizenship(): ?string
    {
        return $this->citizenship;
    }

    /**
     * @return string|null
     */
    public function getSnils(): ?string
    {
        return $this->snils;
    }

    /**
     * @return string|null
     */
    public function getInn(): ?string
    {
        return $this->inn;
    }

    /**
     * @return string|null
     */
    public function getSelfEmployed(): ?string
    {
        return $this->selfEmployed;
    }




}
