<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $uvProtection;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: true)]
    private $company;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Campain::class)]
    private $campain;

    public function __toString()
    {
        return "#" . $this->getId() . " " . $this->name;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUvProtection(): ?int
    {
        return $this->uvProtection;
    }

    public function setUvProtection(?int $uvProtection): self
    {
        $this->uvProtection = $uvProtection;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get the value of campain
     */
    public function getCampain()
    {
        return $this->campain;
    }

    /**
     * Set the value of campain
     *
     * @return  self
     */
    public function setCampain($campain)
    {
        $this->campain = $campain;

        return $this;
    }
}
