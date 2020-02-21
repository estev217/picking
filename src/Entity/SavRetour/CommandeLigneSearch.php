<?php

namespace App\Entity\SavRetour;

class CommandeLigneSearch
{
    /**
     * @var Commande|null
     */
    private $commande;

    /**
     * @var string|null
     */
    private $gencod;

    /**
     * @var bool|null
     */
    private $encours;

    /**
     * @return Commande|null
     */
    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    /**
     * @param Commande|null $commande
     */
    public function setCommande(Commande $commande): void
    {
        $this->commande = $commande;
    }

    /**
     * @return string|null
     */
    public function getGencod(): ?string
    {
        return $this->gencod;
    }

    /**
     * @param string|null $gencod
     */
    public function setGencod(?string $gencod): void
    {
        $this->gencod = $gencod;
    }

    /**
     * @return bool|null
     */
    public function getEncours(): ?bool
    {
        return $this->encours;
    }

    /**
     * @param bool|null $encours
     */
    public function setEncours(?bool $encours): void
    {
        $this->encours = $encours;
    }
}
