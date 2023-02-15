<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $cutleryNumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?ServiceMidi $serviceMidi = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?ServiceSoir $serviceSoir = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCutleryNumber(): ?int
    {
        return $this->cutleryNumber;
    }

    public function setCutleryNumber(int $cutleryNumber): self
    {
        $this->cutleryNumber = $cutleryNumber;

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

    public function getServiceMidi(): ?ServiceMidi
    {
        return $this->serviceMidi;
    }

    public function setServiceMidi(?ServiceMidi $serviceMidi): self
    {
        $this->serviceMidi = $serviceMidi;

        return $this;
    }

    public function getServiceSoir(): ?ServiceSoir
    {
        return $this->serviceSoir;
    }

    public function setServiceSoir(?ServiceSoir $serviceSoir): self
    {
        $this->serviceSoir = $serviceSoir;

        return $this;
    }
}
