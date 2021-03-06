<?php

namespace App\Entity;

class Device
{
    private $id;
    private $latitude;
    private $longtitude;
    private $locationType;
    private $address;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Device
    {
        $this->id = $id;
        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): Device
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongtitude(): float
    {
        return $this->longtitude;
    }

    public function setLongtitude(float $longtitude): Device
    {
        $this->longtitude = $longtitude;
        return $this;
    }

    public function getLocationType(): string
    {
        return $this->locationType;
    }

    public function setLocationType(string $locationType): Device
    {
        $this->locationType = $locationType;
        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): Device
    {
        $this->address = $address;
        return $this;
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'latitude' => $this->latitude,
            'longtitude' => $this->longtitude,
            'locationType' => $this->locationType,
            'address' => $this->address
        ];
    }
}