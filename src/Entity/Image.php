<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $filepath = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToOne(mappedBy: 'image', cascade: ['persist', 'remove'])]
    private ?Plat $plat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilepath(): ?string
    {
        return $this->filepath;
    }

    public function setFilepath(string $filepath): self
    {
        $this->filepath = $filepath;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPlat(): ?Plat
    {
        return $this->plat;
    }

    public function setPlat(?Plat $plat): self
    {
        // unset the owning side of the relation if necessary
        if ($plat === null && $this->plat !== null) {
            $this->plat->setImage(null);
        }

        // set the owning side of the relation if necessary
        if ($plat !== null && $plat->getImage() !== $this) {
            $plat->setImage($this);
        }

        $this->plat = $plat;

        return $this;
    }
}