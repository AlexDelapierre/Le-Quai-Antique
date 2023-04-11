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
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $filename = null;

    #[ORM\OneToOne(mappedBy: 'image', cascade: ['persist'])]
    private ?Plat $plat = null;

    #[ORM\OneToOne(mappedBy: 'image', cascade: ['persist', 'remove'])]
    private ?Galerie $galerie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

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

    public function getGalerie(): ?Galerie
    {
        return $this->galerie;
    }

    public function setGalerie(?Galerie $galerie): self
    {
        // unset the owning side of the relation if necessary
        if ($galerie === null && $this->galerie !== null) {
            $this->galerie->setImage(null);
        }

        // set the owning side of the relation if necessary
        if ($galerie !== null && $galerie->getImage() !== $this) {
            $galerie->setImage($this);
        }

        $this->galerie = $galerie;

        return $this;
    }

    public function __toString(){
        return $this->getFilename();
    }
}