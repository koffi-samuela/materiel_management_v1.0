<?php

namespace App\Entity;

use App\Repository\MaterialKindRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterialKindRepository::class)]
#[ORM\Table('material_kind')]
class MaterialKind
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Material::class, mappedBy: 'materialKind')]
    private Collection $belong_to;

    public function __construct()
    {
        $this->belong_to = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Material>
     */
    public function getBelongTo(): Collection
    {
        return $this->belong_to;
    }

    public function addBelongTo(Material $belongTo): static
    {
        if (!$this->belong_to->contains($belongTo)) {
            $this->belong_to->add($belongTo);
            $belongTo->setMaterialKind($this);
        }

        return $this;
    }

    public function removeBelongTo(Material $belongTo): static
    {
        if ($this->belong_to->removeElement($belongTo)) {
            // set the owning side to null (unless already changed)
            if ($belongTo->getMaterialKind() === $this) {
                $belongTo->setMaterialKind(null);
            }
        }

        return $this;
    }
}
