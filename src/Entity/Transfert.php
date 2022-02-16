<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TransfertRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message="Le montant de transfert est obligatoire")
     */
    private $montantTransfert;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"transferts_read"})
     * @Assert\NotBlank(message="La date de transfert est obligatoire")
     */
    private $DateTransfert;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="transferts")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"transferts_read"})
     * @Assert\NotBlank(message="Le client envoyeur est obligatoire")
     */
    private $envoyeur;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="destTranferts")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"transferts_read"})
     * @Assert\NotBlank(message="Le client destinataire est obligatoire")
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
