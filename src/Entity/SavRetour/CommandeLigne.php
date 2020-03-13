<?php

namespace App\Entity\SavRetour;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ex table T_SAVRETOUR_COMMANDES
 *
 * @ORM\Entity(repositoryClass="App\Repository\SavRetour\CommandeLigneRepository")
 */
class CommandeLigne
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SavRetour\Commande", inversedBy="num_cmd")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;

    /**
     * @ORM\Column(type="string", length=13)
     */
    private $gencod;

    /**
     * @ORM\Column(type="integer")
     */
    private $qte;

    /**
     * @ORM\Column(type="boolean")
     */
    private $encours = false;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $picking;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

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

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getEncours(): ?bool
    {
        return $this->encours;
    }

    public function setEncours(bool $encours): self
    {
        $this->encours = $encours;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPicking(): ?int
    {
        return $this->picking;
    }

    public function setPicking(?int $picking): self
    {
        $this->picking = $picking;

        return $this;
    }
}
