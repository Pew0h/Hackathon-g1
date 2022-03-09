<?php

namespace App\Entity;

use App\Repository\CampainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampainRepository::class)]
class Campain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'datetime')]
    private $startDate;

    #[ORM\Column(type: 'datetime')]
    private $endDate;

    #[ORM\OneToMany(mappedBy: 'campain', targetEntity: CampainRegistration::class, orphanRemoval: true)]
    private $campainRegistrations;

    #[ORM\OneToOne(mappedBy: 'campain', targetEntity: Qcm::class, cascade: ['persist', 'remove'])]
    private $qcm;

    #[ORM\Column(type: 'text', nullable: true)]
    private $qcm_file;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'campains')]
    #[ORM\JoinColumn(name: "product_id", referencedColumnName: "id")]
    private $product;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'campains')]
    #[ORM\JoinColumn(name: "company_id", referencedColumnName: "id")]
    private $company;

    public function __construct()
    {
        $this->campainRegistrations = new ArrayCollection();
    }

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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return Collection<int, CampainRegistration>
     */
    public function getCampainRegistrations(): Collection
    {
        return $this->campainRegistrations;
    }

    public function addCampainRegistration(CampainRegistration $campainRegistration): self
    {
        if (!$this->campainRegistrations->contains($campainRegistration)) {
            $this->campainRegistrations[] = $campainRegistration;
            $campainRegistration->setCampain($this);
        }

        return $this;
    }

    public function removeCampainRegistration(CampainRegistration $campainRegistration): self
    {
        if ($this->campainRegistrations->removeElement($campainRegistration)) {
            // set the owning side to null (unless already changed)
            if ($campainRegistration->getCampain() === $this) {
                $campainRegistration->setCampain(null);
            }
        }

        return $this;
    }

    public function getQcm()
    {
        return $this->qcm;
    }

    public function setQcm($qcm): self
    {
        if (is_object($qcm)) {
            // set the owning side of the relation if necessary
            if ($qcm->getCampain() !== $this) {
                $qcm->setCampain($this);
            }
        }

        $this->qcm = $qcm;

        return $this;
    }

    /**
     * Get the value of product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set the value of product
     *
     * @return  self
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get the value of company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set the value of company
     *
     * @return  self
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get the value of qcmFile
     */
    public function getQcmFile()
    {
        return $this->qcm_file;
    }

    /**
     * Set the value of qcm_file
     *
     * @return  self
     */
    public function setQcmFile($qcm_file)
    {
        $this->qcm_file = $qcm_file;

        return $this;
    }
}
