<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\VersementRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;


use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VersementRepository::class)
 * @ApiResource(
 *  subresourceOperations={
 *      "api_clients_versements_get_subresource"={
 *          "normalization_context"={"groups"="versements_subresource"}      
 *      } 
 *  },
 *  itemOperations={"GET", "solde"={
 *          "method"="post",
 *          "path" = "/versements/{id}/solde",
 *          "controller" = "App\Controller\CalculSoldeController"
 *      } 
 *  },
 *  normalizationContext={
 *      "groups"= "versements_read"
 *  },
 *  attributes={
 *      "order":{"id":"desc"}      
 *  }
 * )
 * 
 */
class Versement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"versements_read", "clients_read", "versements_subresource"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"versements_read", "clients_read", "versements_subresource"})  
     * @Assert\NotBlank(message="Le Montant de compte est obligatoire")
     * @Assert\Type(type="numeric", message = "Le solde doit être numérique !")
     */
    private $montantVersement;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"versements_read", "clients_read", "versements_subresource"})
     * @Assert\NotBlank(message="La Date de versement est obligatoire")
     */
    private $dateVersement;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="versements")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"versements_read"})
     * @Assert\NotBlank(message="Le client est obligatoire")
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantVersement(): ?int
    {
        return $this->montantVersement;
    }

    public function setMontantVersement(int $montantVersement): self
    {
        $this->montantVersement = $montantVersement;

        return $this;
    }

    public function getDateVersement(): ?\DateTimeInterface
    {
        return $this->dateVersement;
    }

    public function setDateVersement(\DateTimeInterface $dateVersement): self
    {
        $this->dateVersement = $dateVersement;

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
