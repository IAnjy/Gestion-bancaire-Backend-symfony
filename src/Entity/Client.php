<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @ApiResource(
 *  normalizationContext={
 *      "groups"= "clients_read"
 *  }
 * )
 * @UniqueEntity("numCompte", message = "Un Client a déjà ce numéro de compte !")
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"clients_read", "versements_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"clients_read", "versements_read"})
     * @Assert\NotBlank(message="Le numéro de compte est obligatoire")
     */
    private $numCompte;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"clients_read", "versements_read"})
     * @Assert\NotBlank(message="Le nom de compte est obligatoire")
     * @Assert\Length(min = 3, minMessage="Le Nom doit faire au moins 3 caractères")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"clients_read", "versements_read"})
     */
    private $prenoms;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"clients_read", "versements_read"})
     * @Assert\NotBlank(message="Le nom de compte est obligatoire")
     * @Assert\Type(type="numeric", message = "Le solde doit être numérique !")
     */
    private $solde;

    /**
     * @ORM\OneToMany(targetEntity=Versement::class, mappedBy="client", orphanRemoval=true)
     * @Groups({"clients_read"})
     * @ApiSubresource
     */
    private $versements;

    /**
     * @ORM\OneToMany(targetEntity=Retrait::class, mappedBy="client", orphanRemoval=true)
     */
    private $retraits;

    public function __construct()
    {
        $this->versements = new ArrayCollection();
        $this->retraits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCompte(): ?string
    {
        return $this->numCompte;
    }

    public function setNumCompte(string $numCompte): self
    {
        $this->numCompte = $numCompte;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): self
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * @return Collection|Versement[]
     */
    public function getVersements(): Collection
    {
        return $this->versements;
    }

    public function addVersement(Versement $versement): self
    {
        if (!$this->versements->contains($versement)) {
            $this->versements[] = $versement;
            $versement->setClient($this);
        }

        return $this;
    }

    public function removeVersement(Versement $versement): self
    {
        if ($this->versements->removeElement($versement)) {
            // set the owning side to null (unless already changed)
            if ($versement->getClient() === $this) {
                $versement->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Retrait[]
     */
    public function getRetraits(): Collection
    {
        return $this->retraits;
    }

    public function addRetrait(Retrait $retrait): self
    {
        if (!$this->retraits->contains($retrait)) {
            $this->retraits[] = $retrait;
            $retrait->setClient($this);
        }

        return $this;
    }

    public function removeRetrait(Retrait $retrait): self
    {
        if ($this->retraits->removeElement($retrait)) {
            // set the owning side to null (unless already changed)
            if ($retrait->getClient() === $this) {
                $retrait->setClient(null);
            }
        }

        return $this;
    }
}
