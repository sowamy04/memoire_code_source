<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PersonneConfianceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PersonneConfianceRepository::class)
 * @ApiResource(
 *  attributes={ 
 *  "input_formats"={
 *    "json"={"application/ld+json", "application/json"}
 *  }, 
 *  "output_formats"={
 *      "json"={"application/ld+json", "application/json"}
 *  } 
 * },
 *  collectionOperations ={
 *  "get"= {
 *    "normalization_context"={"groups":"meritoire:read"},
 *    "access_control"="(is_granted('ROLE_SUPER_ADMIN'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource"
 *   },
 * "lister_meritoire" = {
 *    "method": "GET",
 *    "path": "simple_users/personne_confiances", 
 *    "normalization_context"={"groups":"meritoire:read"},
 *    "access_control"="(is_granted('ROLE_SUPER_ADMIN'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource"
 * },
 * "add_meritoire" = {
 *    "method": "POST",
 *   "path": "/personne_confiances", 
 *   "normalization_context"={"groups":"meritoire:read"},
 *   "access_control"="(is_granted('ROLE_USER'))",
 *   "access_control_message"="Vous n'avez pas access à cetteThe Ressource",
 *   "route_name"="add_meritoire",
 * },
 * },
 * itemOperations= {
 *  "get_meritoire" = {
 *    "method": "GET",
 *   "path": "/simple_users/personne_confiances/{id}",
 *   "normalization_context"={"groups":"meritoire:read"},
 *   "access_control"="(is_granted('ROLE_USER') or is_granted('ROLE_ADMIN') or is_granted('ROLE_SUPER_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource"
 *  },
 * }
 * )
 */
class PersonneConfiance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"meritoire:read", "alerte:read", "simple_user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"meritoire:read", "alerte:read", "simple_user:read"})
     */
    private $nomComplet;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"meritoire:read", "alerte:read", "simple_user:read"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"meritoire:read", "alerte:read", "simple_user:read"})
     */
    private $statut;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"meritoire:read", "alerte:read", "simple_user:read"})
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=SimpleUser::class, inversedBy="personneConfiances")
     * @Groups({"meritoire:read"})
     */
    private $simpleUser;

    /**
     * @ORM\OneToMany(targetEntity=Alerte::class, mappedBy="meritoire")
     */
    private $alertes;

    /**
     * @ORM\ManyToOne(targetEntity=Itineraire::class, inversedBy="personneConfiances")
     */
    private $itineraire;

    public function __construct()
    {
        $this->alertes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSimpleUser(): ?SimpleUser
    {
        return $this->simpleUser;
    }

    public function setSimpleUser(?SimpleUser $simpleUser): self
    {
        $this->simpleUser = $simpleUser;

        return $this;
    }

    /**
     * @return Collection|Alerte[]
     */
    public function getAlertes(): Collection
    {
        return $this->alertes;
    }

    public function addAlerte(Alerte $alerte): self
    {
        if (!$this->alertes->contains($alerte)) {
            $this->alertes[] = $alerte;
            $alerte->setMeritoire($this);
        }

        return $this;
    }

    public function removeAlerte(Alerte $alerte): self
    {
        if ($this->alertes->removeElement($alerte)) {
            // set the owning side to null (unless already changed)
            if ($alerte->getMeritoire() === $this) {
                $alerte->setMeritoire(null);
            }
        }

        return $this;
    }

    public function getItineraire(): ?Itineraire
    {
        return $this->itineraire;
    }

    public function setItineraire(?Itineraire $itineraire): self
    {
        $this->itineraire = $itineraire;

        return $this;
    }
}
