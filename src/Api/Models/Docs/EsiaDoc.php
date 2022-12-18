<?php

namespace Pavelrockjob\Esia\Api\Models\Docs;

use Pavelrockjob\Esia\Api\Models\Abstract\EsiaModel;

class EsiaDoc extends EsiaModel
{
    protected ?int $id = null;
    protected ?string $type = null;
    protected ?string $vrfStu = null;
    protected ?string $series = null;
    protected ?string $number = null;
    protected ?string $issueDate = null;
    protected ?string $issueId = null;
    protected ?string $issuedBy = null;
    protected ?string $eTag = null;
    protected ?string $expiryDate = null;
    protected ?string $vrfValStu = null;
    protected ?string $fmsValid = null;

    /**
     * @return string|null
     */
    public function getVrfStu(): ?string
    {
        return $this->vrfStu;
    }

    /**
     * @return string|null
     */
    public function getExpiryDate(): ?string
    {
        return $this->expiryDate;
    }

    /**
     * @return string|null
     */
    public function getVrfValStu(): ?string
    {
        return $this->vrfValStu;
    }

    /**
     * @return string|null
     */
    public function getFmsValid(): ?string
    {
        return $this->fmsValid;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getSeries(): ?string
    {
        return $this->series;
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @return string|null
     */
    public function getIssueDate(): ?string
    {
        return $this->issueDate;
    }

    /**
     * @return string|null
     */
    public function getIssueId(): ?string
    {
        return $this->issueId;
    }

    /**
     * @return string|null
     */
    public function getIssuedBy(): ?string
    {
        return $this->issuedBy;
    }

    /**
     * @return string|null
     */
    public function getETag(): ?string
    {
        return $this->eTag;
    }
}
