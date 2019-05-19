<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrajetRepository")
 */
class Trajet
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
    private $villeDep;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $villeArrivee;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDep;

    /**
     * @ORM\Column(type="time")
     */
    private $heureDep;

    /**
     * @ORM\Column(type="integer")
     */
    private $placeLibres;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="idTraj")
     */
    private $reservations;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Voiture", inversedBy="trajets", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $voiture;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVilleDep(): ?string
    {
        return $this->villeDep;
    }

    public function setVilleDep(string $villeDep): self
    {
        $this->villeDep = $villeDep;

        return $this;
    }

    public function getVilleArrivee(): ?string
    {
        return $this->villeArrivee;
    }

    public function setVilleArrivee(string $villeArrivee): self
    {
        $this->villeArrivee = $villeArrivee;

        return $this;
    }

    public function getDateDep(): ?\DateTimeInterface
    {
        return $this->dateDep;
    }

    public function setDateDep(\DateTimeInterface $dateDep): self
    {
        $this->dateDep = $dateDep;

        return $this;
    }

    public function getHeureDep(): ?\DateTimeInterface
    {
        return $this->heureDep;
    }

    public function setHeureDep(\DateTimeInterface $heureDep): self
    {
        $this->heureDep = $heureDep;

        return $this;
    }

    public function getPlaceLibres(): ?int
    {
        return $this->placeLibres;
    }

    public function setPlaceLibres(int $placeLibres): self
    {
        $this->placeLibres = $placeLibres;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setIdTraj($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getIdTraj() === $this) {
                $reservation->setIdTraj(null);
            }
        }

        return $this;
    }

    public function getVoiture(): ?Voiture
    {
        return $this->voiture;
    }

    public function setVoiture(?Voiture $voiture): self
    {
        $this->voiture = $voiture;

        return $this;
    }
}
