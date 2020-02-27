<?php

namespace App\Entity\SavRetour;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ex table TR_SAVRETOUR_COMMANDE
 *
 * @ORM\Entity(repositoryClass="App\Repository\SavRetour\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SavRetour\CommandeLigne", mappedBy="commande", orphanRemoval=true)
     */
    private $num_cmd;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $demandeur;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $magasin_cedant;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $destination;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $solde = false;

    /**
     * @ORM\Column(type="string", length=35, unique=true)
     */
    private $num_commande;

    public function __construct()
    {
        $this->num_cmd = new ArrayCollection();
        $this->date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|CommandeLigne[]
     */
    public function getNumCmd(): Collection
    {
        return $this->num_cmd;
    }

    public function addNumCmd(CommandeLigne $numCmd): self
    {
        if (!$this->num_cmd->contains($numCmd)) {
            $this->num_cmd[] = $numCmd;
            $numCmd->setCommande($this);
        }

        return $this;
    }

    public function removeNumCmd(CommandeLigne $numCmd): self
    {
        if ($this->num_cmd->contains($numCmd)) {
            $this->num_cmd->removeElement($numCmd);
            // set the owning side to null (unless already changed)
            if ($numCmd->getCommande() === $this) {
                $numCmd->setCommande(null);
            }
        }

        return $this;
    }

    public function getDemandeur(): ?string
    {
        return $this->demandeur;
    }

    public function setDemandeur(string $demandeur): self
    {
        $this->demandeur = $demandeur;

        return $this;
    }

    public function getMagasinCedant(): ?string
    {
        return $this->magasin_cedant;
    }

    public function setMagasinCedant(string $magasin_cedant): self
    {
        $this->magasin_cedant = $magasin_cedant;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

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

    public function getSolde(): ?bool
    {
        return $this->solde;
    }

    public function setSolde(bool $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getNumCommande(): ?string
    {
        return $this->num_commande;
    }

    public function setNumCommande(string $num_commande): self
    {
        $this->num_commande = $num_commande;

        return $this;
    }
}
