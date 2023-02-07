<?php

namespace App\Entity;

use App\Repository\ConfigSiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConfigSiteRepository::class)]
class ConfigSite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $maxCouverts = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $horaires = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaxCouverts(): ?int
    {
        return $this->maxCouverts;
    }

    public function setMaxCouverts(int $maxCouverts): self
    {
        $this->maxCouverts = $maxCouverts;

        return $this;
    }

    public function getHoraires(): ?string
    {
        return $this->horaires;
    }

    public function setHoraires(string $horaires): self
    {
        $this->horaires = $horaires;

        return $this;
    }
}
