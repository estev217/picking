<?php

namespace App\Entity\SavRetour;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ex table T_SAVRETOUR_PICKING
 *
 * @ORM\Entity(repositoryClass="App\Repository\SavRetour\PickingRepository")
 */
class Picking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=35)
     */
    private $num_cmd;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $imei;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $gencod;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_heure;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $num_dossier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCmd(): ?string
    {
        return $this->num_cmd;
    }

    public function setNumCmd(string $num_cmd): self
    {
        $this->num_cmd = $num_cmd;

        return $this;
    }

    public function getImei(): ?string
    {
        return $this->imei;
    }

    public function setImei(string $imei): self
    {
        $this->imei = $imei;

        return $this;
    }

    public function getGencod(): ?string
    {
        return $this->gencod;
    }

    public function setGencod(string $gencod): self
    {
        $this->gencod = $gencod;

        return $this;
    }

    public function getDateHeure(): ?\DateTimeInterface
    {
        return $this->date_heure;
    }

    public function setDateHeure(\DateTimeInterface $date_heure): self
    {
        $this->date_heure = $date_heure;

        return $this;
    }

    public function getNumDossier(): ?string
    {
        return $this->num_dossier;
    }

    public function setNumDossier(string $num_dossier): self
    {
        $this->num_dossier = $num_dossier;

        return $this;
    }
}
