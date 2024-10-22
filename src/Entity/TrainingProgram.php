<?php

namespace App\Entity;

use App\Repository\TrainingProgramRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainingProgramRepository::class)]
#[ORM\Table('training_programs')]

class TrainingProgram
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $level = null;

    #[ORM\OneToMany(targetEntity: Borrowing::class, mappedBy: 'trainingProgram')]
    private Collection $concern;

    public function __construct()
    {
        $this->concern = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): static
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Collection<int, Borrowing>
     */
    public function getConcern(): Collection
    {
        return $this->concern;
    }

    public function addConcern(Borrowing $concern): static
    {
        if (!$this->concern->contains($concern)) {
            $this->concern->add($concern);
            $concern->setTrainingProgram($this);
        }

        return $this;
    }

    public function removeConcern(Borrowing $concern): static
    {
        if ($this->concern->removeElement($concern)) {
            // set the owning side to null (unless already changed)
            if ($concern->getTrainingProgram() === $this) {
                $concern->setTrainingProgram(null);
            }
        }

        return $this;
    }
}
