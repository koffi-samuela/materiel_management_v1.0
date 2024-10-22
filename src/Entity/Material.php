<?php

namespace App\Entity;

use App\Repository\MaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterialRepository::class)]
#[ORM\Table('materials')]

class Material
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $serial_number = null;

    #[ORM\Column(length: 50)]
    private ?string $tag_number = null;

    #[ORM\Column(length: 255)]
    private ?string $comment = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $location = null;

    #[ORM\Column]
    private ?bool $is_available = null;

    #[ORM\ManyToOne(inversedBy: 'belong_to')]
    private ?MaterialKind $materialKind = null;

    #[ORM\OneToMany(targetEntity: Borrowing::class, mappedBy: 'material')]
    private Collection $relate_to;

    public function __construct()
    {
        $this->relate_to = new ArrayCollection();
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

    public function getSerialNumber(): ?string
    {
        return $this->serial_number;
    }

    public function setSerialNumber(string $serial_number): static
    {
        $this->serial_number = $serial_number;

        return $this;
    }

    public function getTagNumber(): ?string
    {
        return $this->tag_number;
    }

    public function setTagNumber(string $tag_number): static
    {
        $this->tag_number = $tag_number;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->is_available;
    }

    public function setIsAvailable(bool $is_available): static
    {
        $this->is_available = $is_available;

        return $this;
    }

    public function getMaterialKind(): ?MaterialKind
    {
        return $this->materialKind;
    }

    public function setMaterialKind(?MaterialKind $materialKind): static
    {
        $this->materialKind = $materialKind;

        return $this;
    }

    /**
     * @return Collection<int, Borrowing>
     */
    public function getRelateTo(): Collection
    {
        return $this->relate_to;
    }

    public function addRelateTo(Borrowing $relateTo): static
    {
        if (!$this->relate_to->contains($relateTo)) {
            $this->relate_to->add($relateTo);
            $relateTo->setMaterial($this);
        }

        return $this;
    }

    public function removeRelateTo(Borrowing $relateTo): static
    {
        if ($this->relate_to->removeElement($relateTo)) {
            // set the owning side to null (unless already changed)
            if ($relateTo->getMaterial() === $this) {
                $relateTo->setMaterial(null);
            }
        }

        return $this;
    }
}
