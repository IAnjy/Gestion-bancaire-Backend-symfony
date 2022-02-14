<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TransfertRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TransfertRepository::class)
 * @ApiResource(
 *  itemOperations={"GET"},
 *  normalizationContext={"groups" = "transferts_read"}
 * )
 */
class Transfert
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"transferts_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transferts_read"})
     */
    private $montantTransfert;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"transferts_read"})
     */
    private $DateTransfert;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="transferts")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"transferts_read"})
     */
    private $envoyeur;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="destTranferts")
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
        return $this->DateTransfert;
    }

    public function setDateTransfert(\DateTimeInterface $DateTransfert): self
    {
        $this->DateTransfert = $DateTransfert;

        return $this;
    }

    public function getEnvoyeur(): ?Client
    {
        return $this->envoyeur;
    }

    public function setEnvoyeur(?Client $envoyeur): self
    {
        $this->envoyeur = $envoyeur;

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
