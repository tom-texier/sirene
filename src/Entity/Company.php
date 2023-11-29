<?php

namespace App\Entity;

use DateTime;

class Company
{
    /**
     * @var null|string
     */
    protected ?string $name;

    /**
     * @var null|string
     */
    protected ?string $siret;

    /**
     * @var null|string
     */
    protected ?string $siren;

    /**
     * @var null|string
     */
    protected ?string $address;

    /**
     * @var string|null
     */
    protected ?string $city;

    /**
     * @var string|null
     */
    protected ?string $postalCode;

    /**
     * @var null|string
     */
    protected ?string $category;

    /**
     * @var DateTime|null
     */
    protected ?DateTime $createdAt;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Company
     */
    public function setName(?string $name): Company
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getSiret(): ?string
    {
        return $this->siret;
    }

    /**
     * @param string|null $siret
     * @return Company
     */
    public function setSiret(?string $siret): Company
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * @return string
     */
    public function getSiren(): ?string
    {
        return $this->siren;
    }

    /**
     * @param string|null $siren
     * @return Company
     */
    public function setSiren(?string $siren): Company
    {
        $this->siren = $siren;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     * @return Company
     */
    public function setAddress(?string $address): Company
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return Company
     */
    public function setCity(?string $city): Company
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string|null $postalCode
     * @return $this
     */
    public function setPostalCode(?string $postalCode): Company
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     * @return Company
     */
    public function setCategory(?string $category): Company
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     * @return Company
     */
    public function setCreatedAt(?DateTime $createdAt): Company
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Format the full address
     *
     * @param array $datas
     * @return $this
     */
    public function formatAddress(array $datas): Company
    {
        $address = "";

        if(!empty($datas['numeroVoieEtablissement'])) $address .= $datas['numeroVoieEtablissement'] . " ";

        if(!empty($datas['indiceRepetitionEtablissement'])) $address .= $datas['indiceRepetitionEtablissement'] . " ";

        if(!empty($datas['typeVoieEtablissement'])) $address .= $datas['typeVoieEtablissement'] . " ";

        if(!empty($datas['libelleVoieEtablissement'])) $address .= $datas['libelleVoieEtablissement'] . " ";

        if(!empty($datas['codePostalEtablissement'])) {
            $address .= $datas['codePostalEtablissement'] . " ";
        }

        $this->setPostalCode($datas['codePostalEtablissement'] ?? null);

        if(!empty($datas['libelleCommuneEtablissement'])) {
            $address .= $datas['libelleCommuneEtablissement'] . " ";
        }

        $this->setCity($datas['libelleCommuneEtablissement'] ?? null);

        return $this->setAddress(trim($address));
    }
}