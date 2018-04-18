<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DataRepository")
 */
class Data
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $piece;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $capteur;

    /**
     * @ORM\Column(type="float", scale=2)
     */
    private $valeur;


    /**
     * @ORM\Column(type="datetime")
     */
    private $dateTime;



    public function getId()
    {
        return $this->id;
    }

    public function getPiece(): ?string
    {
        return $this->piece;
    }

    public function setPiece(string $piece): self
    {
        $this->piece = $piece;

        return $this;
    }

    public function getCapteur(): ?string
    {
        return $this->capteur;
    }

    public function setCapteur(string $capteur): self
    {
        $this->capteur = $capteur;

        return $this;
    }

    public function getValeur(): ?float
    {
        return $this->valeur;
    }

    public function setValeur(float $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function setDateTime(\DateTime $dateTime): self
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getDateTime(): ?\DateTime
    {
        return $this->dateTime;
    }

}
