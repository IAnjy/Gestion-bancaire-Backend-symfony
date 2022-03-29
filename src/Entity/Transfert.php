<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TransfertRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * subresourceOperations={
 *      "api_clients_transferts_get_subresource"={
 *          "normalization_context"={"groups"="transferts_subresource"}      
 *      } 
 *  },
 *  itemOperations={"GET"},
 * normalizationContext={
 *      "groups"= "transferts_read"
 *  }
 * )
 * @ORM\Entity(repositoryClass=TransfertRepository::class)
 */
class Transfert
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"transferts_read", "clients_read", "transferts_subresource"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transferts_read", "clients_read", "transferts_subresource"})
     */
    private $montantTransfert;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"transferts_read", "clients_read", "transferts_subresource"})
     */
    private $dateTransfert;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="expediteurs")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"transferts_read"})
     */
    private $expediteur;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="destinataires")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"transferts_read"})
     */
    private $destinataire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantTransfert(): ?int
    {
        return $this->montantTransfert;
    }

    public function setMontantTransfert(int $montantTransfert): self
    {
        $this->montantTransfert = $montantTransfert;

        return $this;
    }

    public function getDateTransfert(): ?\DateTimeInterface
    {
        return $this->dateTransfert;
    }

    public function setDateTransfert(\DateTimeInterface $dateTransfert): self
    {
        $this->dateTransfert = $dateTransfert;

        return $this;
    }

    public function getExpediteur(): ?Client
    {
        return $this->expediteur;
    }

    public function setExpediteur(?Client $expediteur): self
    {
        $this->expediteur = $expediteur;

        return $this;
    }

    public function getDestinataire(): ?Client
    {
        return $this->destinataire;
    }

    public function setDestinataire(?Client $destinataire): self
    {
        $this->destinataire = $destinataire;

        return $this;
    }
}
