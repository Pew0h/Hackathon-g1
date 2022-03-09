<?php

namespace App\Entity;

use App\Repository\CampainRegistrationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampainRegistrationRepository::class)]
class CampainRegistration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text', options: ["default", "pending"])]
    private $status;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'campainRegistrations')]
    #[ORM\JoinColumn(nullable: false)]
    private $tester;

    #[ORM\OneToOne(mappedBy: 'campainRegistration', targetEntity: UserQcmResponse::class, cascade: ['persist', 'remove'])]
    private $userQcmResponse;

    #[ORM\ManyToOne(targetEntity: Campain::class, inversedBy: 'campainRegistrations')]
    #[ORM\JoinColumn(nullable: false)]
    private $campain;

    const STATUS_PENDING = "pending";
    const STATUS_ACCEPTED = "accepted";
    const STATUS_REFUSED = "refused";

    public function __toString()
    {
        return $this->campain . " " . $this->tester;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTester(): ?User
    {
        return $this->tester;
    }

    public function setTester(?User $tester): self
    {
        $this->tester = $tester;

        return $this;
    }

    public function getUserQcmResponse(): ?UserQcmResponse
    {
        return $this->userQcmResponse;
    }

    public function setUserQcmResponse(UserQcmResponse $userQcmResponse): self
    {
        // set the owning side of the relation if necessary
        if ($userQcmResponse->getCampainRegistration() !== $this) {
            $userQcmResponse->setCampainRegistration($this);
        }

        $this->userQcmResponse = $userQcmResponse;

        return $this;
    }

    public function getCampain(): ?Campain
    {
        return $this->campain;
    }

    public function setCampain(?Campain $campain): self
    {
        $this->campain = $campain;

        return $this;
    }
}
