<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RetraitRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=RetraitRepository::class)
 * @ApiResource(
 *  subresourceOperations={
 *      "api_clients_retraits_get_subresource"={
 *          "normalization_context"={"groups"="retraits_subresource"}      
 *      } 
 *  },
 * itemOperations={"GET"},
 * normalizationContext={
 *      "groups"= "retraits_read"
 *  },
 *  attributes={ "order":{"id":"desc"} }
 * )
 * @UniqueEntity("numCheque", message = "le numéro de chèque déjà existant !")
 */
class Retrait
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"retraits_read", "clients_read", "retraits_subresource"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"retraits_read", "clients_read", "retraits_subresource"})
     * @Assert\NotBlank(message="Le numéro chèque est obligatoire")
     * 
     */
    private $numCheque;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"retraits_read", "clients_read", "retraits_subresource"})
     * @Assert\NotBlank(message="Le Montant de retrait est obligatoire")
     * @Assert\Type(type="numeric", message = "Le solde doit être numérique !")
     */
    private $montantRetrait;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"retraits_read", "clients_read", "retraits_subresource"})
     * @Assert\NotBlank(message="La Date de retrait est obligatoire")
     */
    private $dateRetrait;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="retraits")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"retraits_read"})
     * @Assert\NotBlank(message="Le client est obligatoire")
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
