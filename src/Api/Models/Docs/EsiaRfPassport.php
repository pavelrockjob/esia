<?php

namespace Pavelrockjob\Esia\Api\Models\Docs;

class EsiaRfPassport
{
    private ?int $id = null;
    private ?string $type = null;
    private ?string $crfStu = null;
    private ?string $series = null;
    private ?string $number = null;
    private ?string $issueDate = null;
    private ?string $issueId = null;
    private ?string $issuedBy = null;
    private ?string $eTag = null;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value){
            if (property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
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
    public function getCrfStu(): ?string
    {
        return $this->crfStu;
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
