<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
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

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Product::class, orphanRemoval: false)]
    private $products;
    
    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Campain::class, orphanRemoval: true)]
    private $campains;

    public function __construct()
    {
        $this->products = new Collection();
        $this->campains = new Collection();
    }

    public function __toString(){
        return "#".$this->getId() . " " . $this->name;
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

    public function getProducts(): ?Collection
    {
        // var_dump($this->products);
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCompany($this);
        }
        
        return $this;
    }
    
    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCompany() === $this) {
                $product->setCompany(null);
            }
        }

        return $this;
    }


    public function addCampain(Campain $campain): self
    {
        if (!$this->campains->contains($campain)) {
            $this->campains[] = $campain;
            $campain->setCompany($this);
        }

        return $this;
    }

    public function removeCampain(Campain $campain): self
    {
        if ($this->campains->removeElement($campain)) {
            if ($campain->getCompany() === $this) {
                $campain->setCompany(null);
            }
        }
        return $this;
    }

    /**
     * Get the value of campains
     */ 
    public function getCampains()
    {
        return $this->campains;
    }

    /**
     * Set the value of campains
     *
     * @return  self
     */ 
    public function setCampains($campains)
    {
        $this->campains = $campains;

        return $this;
    }
}
