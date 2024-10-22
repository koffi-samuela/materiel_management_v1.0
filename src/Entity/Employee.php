<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
#[ORM\Table('employees')]

class Employee implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column]
    private ?bool $is_active = null;

    #[ORM\OneToMany(targetEntity: Borrowing::class, mappedBy: 'employee')]
    private Collection $manage;

    #[ORM\OneToMany(targetEntity: Borrowing::class, mappedBy: 'employee_borrow')]
    private Collection $borrow;

    public function __construct()
    {
        $this->manage = new ArrayCollection();
        $this->borrow = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
    }

    /**
     * @return Collection<int, Borrowing>
     */
    public function getManage(): Collection
    {
        return $this->manage;
    }

    public function addManage(Borrowing $manage): static
    {
        if (!$this->manage->contains($manage)) {
            $this->manage->add($manage);
            $manage->setEmployee($this);
        }

        return $this;
    }

    public function removeManage(Borrowing $manage): static
    {
        if ($this->manage->removeElement($manage)) {
            // set the owning side to null (unless already changed)
            if ($manage->getEmployee() === $this) {
                $manage->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Borrowing>
     */
    public function getBorrow(): Collection
    {
        return $this->borrow;
    }

    public function addBorrow(Borrowing $borrow): static
    {
        if (!$this->borrow->contains($borrow)) {
            $this->borrow->add($borrow);
            $borrow->setEmployeeBorrow($this);
        }

        return $this;
    }

    public function removeBorrow(Borrowing $borrow): static
    {
        if ($this->borrow->removeElement($borrow)) {
            // set the owning side to null (unless already changed)
            if ($borrow->getEmployeeBorrow() === $this) {
                $borrow->setEmployeeBorrow(null);
            }
        }

        return $this;
    }
}
