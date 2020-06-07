<?php


namespace App\Entity;


class Car
{
    private ?int $id = null;
    private ?string $manufacturer = null;
    private ?string $model = null;
    private ?\DateTime $issueDate = null;
    private ?int $modelYear = null;
    private ?string $vin = null;
    private ?int $mileage = null;



    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Car
     */
    public function setId(?int $id): Car
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    /**
     * @param string|null $manufacturer
     * @return Car
     */
    public function setManufacturer(?string $manufacturer): Car
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getModel(): ?string
    {
        return $this->model;
    }

    /**
     * @param string|null $model
     * @return Car
     */
    public function setModel(?string $model): Car
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getIssueDate(): ?\DateTime
    {
        return $this->issueDate;
    }

    /**
     * @param \DateTime|null $issueDate
     * @return Car
     */
    public function setIssueDate(?\DateTime $issueDate): Car
    {
        $this->issueDate = $issueDate;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getModelYear(): ?int
    {
        return $this->modelYear;
    }

    /**
     * @param int|null $modelYear
     * @return Car
     */
    public function setModelYear(?int $modelYear): Car
    {
        $this->modelYear = $modelYear;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVin(): ?string
    {
        return $this->vin;
    }

    /**
     * @param string|null $vin
     * @return Car
     */
    public function setVin(?string $vin): Car
    {
        $this->vin = $vin;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    /**
     * @param int|null $mileage
     * @return Car
     */
    public function setMileage(?int $mileage): Car
    {
        $this->mileage = $mileage;
        return $this;
    }
}