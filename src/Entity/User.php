<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "users")]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private bool $agreeTerms;

    #[ORM\ManyToMany(targetEntity: Sector::class, inversedBy: "users", cascade: ["persist"])]
    #[ORM\JoinTable(name: "user_sectors")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id", onDelete: "CASCADE")]
    #[ORM\InverseJoinColumn(name: "sector_id", referencedColumnName: "id", onDelete: "CASCADE")]
    private Collection $sectors;

    public function __construct()
    {
        $this->sectors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function isAgreeTerms(): bool
    {
        return $this->agreeTerms;
    }

    public function setAgreeTerms(bool $agreeTerms): self
    {
        $this->agreeTerms = $agreeTerms;
        return $this;
    }

    public function getSectors(): Collection
    {
        return $this->sectors;
    }

    public function addSector(Sector $sector): self
    {
        if (!$this->sectors->contains($sector)) {
            $this->sectors[] = $sector;
        }
        return $this;
    }

    public function removeSector(Sector $sector): self
    {
        $this->sectors->removeElement($sector);
        return $this;
    }
}
