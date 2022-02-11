<?php

namespace App\Entity;

use App\Repository\RetraitRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RetraitRepository::class)
 */
class Retrait
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numCheque;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantRetrait;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateRetrait;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="retraits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCheque(): ?string
    {
        return $this->numCheque;
    }

    public function setNumCheque(string $numCheque): self
    {
        $this->numCheque = $numCheque;

        return $this;
    }

    public function getMontantRetrait(): ?int
    {
        return $this->montantRetrait;
    }

    public function setMontantRetrait(int $montantRetrait): self
    {
        $this->montantRetrait = $montantRetrait;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
