<?php

namespace App\Entity;

use App\Repository\UserQcmResponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserQcmResponseRepository::class)]
class UserQcmResponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'json')]
    private $content = [];

    #[ORM\OneToOne(inversedBy: 'userQcmResponse', targetEntity: CampainRegistration::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $campainRegistration;

    public function __toString()
    {
        return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return json_encode($this->content, JSON_PRETTY_PRINT);
    }

    public function setContent(array $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCampainRegistration(): ?CampainRegistration
    {
        return $this->campainRegistration;
    }

    public function setCampainRegistration(CampainRegistration $campainRegistration): self
    {
        $this->campainRegistration = $campainRegistration;

        return $this;
    }
}
