<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trajet", inversedBy="reservations")
     */
    private $idTraj;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Passager", inversedBy="reservations")
     */
    private $idPass;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateRes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdTraj(): ?Trajet
    {
        return $this->idTraj;
    }

    public function setIdTraj(?Trajet $idTraj): self
    {
        $this->idTraj = $idTraj;

        return $this;
    }

    public function getIdPass(): ?Passager
    {
        return $this->idPass;
    }

    public function setIdPass(?Passager $idPass): self
    {
        $this->idPass = $idPass;

        return $this;
    }

    public function getDateRes(): ?\DateTimeInterface
    {
        return $this->DateRes;
    }

    public function setDateRes(\DateTimeInterface $DateRes): self
    {
        $this->DateRes = $DateRes;

        return $this;
    }
}
