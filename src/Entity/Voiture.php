<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoitureRepository")
 */
class Voiture
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
    private $modele;

    /**
     * @ORM\Column(type="boolean")
     */
    private $clim;

    /**
     * @ORM\Column(type="boolean")
     */
    private $fumeur;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bagage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Chauffeur", inversedBy="voitures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idCh;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trajet", mappedBy="voiture", orphanRemoval=true)
     */
    private $trajets;

    public function __construct()
    {
        $this->trajets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getClim(): ?bool
    {
        return $this->clim;
    }

    public function setClim(bool $clim): self
    {
        $this->clim = $clim;

        return $this;
    }

    public function getFumeur(): ?bool
    {
        return $this->fumeur;
    }

    public function setFumeur(bool $fumeur): self
    {
        $this->fumeur = $fumeur;

        return $this;
    }

    public function getBagage(): ?bool
    {
        return $this->bagage;
    }

    public function setBagage(bool $bagage): self
    {
        $this->bagage = $bagage;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getIdCh(): ?Chauffeur
    {
        return $this->idCh;
    }

    public function setIdCh(?Chauffeur $idCh): self
    {
        $this->idCh = $idCh;

        return $this;
    }

    /**
     * @return Collection|Trajet[]
     */
    public function getTrajets(): Collection
    {
        return $this->trajets;
    }

    public function addTrajet(Trajet $trajet): self
    {
        if (!$this->trajets->contains($trajet)) {
            $this->trajets[] = $trajet;
            $trajet->addIdVoiture($this);
        }

        return $this;
    }

    public function removeTrajet(Trajet $trajet): self
    {
        if ($this->trajets->contains($trajet)) {
            $this->trajets->removeElement($trajet);
            $trajet->removeIdVoiture($this);
        }
        return $this;
    }
}
