<?php

namespace App\Entity;

use App\Repository\CouvertRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouvertRepository::class)]
class Couvert
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $maxCouverts = null;

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
}
