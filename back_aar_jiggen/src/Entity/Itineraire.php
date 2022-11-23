<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ItineraireRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ItineraireRepository::class)
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
 *    "normalization_context"={"groups":"itineraire:read"},
 *    "access_control"="(is_granted('ROLE_SUPER_ADMIN'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource"
 *   },
 * "lister_itineraires" = {
 *    "method": "GET",
 *    "path": "simple_users/itineraires", 
 *    "normalization_context"={"groups":"itineraire:read"},
 *    "access_control"="(is_granted('ROLE_SUPER_ADMIN'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource"
 * },
 * "add_itineraire" = {
 *    "method": "POST",
 *   "path": "/itineraires", 
 *   "normalization_context"={"groups":"itineraire:read"},
 *   "access_control"="(is_granted('ROLE_USER'))",
 *   "access_control_message"="Vous n'avez pas access à cetteThe Ressource",
 *   "route_name"="add_itineraire",
 * },
 * },
 * itemOperations= {
 *  "get_itineraire" = {
 *    "method": "GET",
 *   "path": "/simple_users/itineraires/{id}",
 *   "normalization_context"={"groups":"itineraire:read"},
 *   "access_control"="(is_granted('ROLE_USER') or is_granted('ROLE_ADMIN') or is_granted('ROLE_SUPER_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource"
 *  },
 * }
 * )
 */
class Itineraire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"itineraire:read", "simple_user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"itineraire:read", "simple_user:read"})
     */
    private $depart;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"itineraire:read", "simple_user:read"})
     */
    private $arrivee;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"itineraire:read", "simple_user:read"})
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=SimpleUser::class, inversedBy="itineraires")
     * @Groups({"itineraire:read"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=PersonneConfiance::class, mappedBy="itineraire")
     * @Groups({"itineraire:read"})
     */
    private $personneConfiances;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latDepart;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longDepart;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latArrivee;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longArrivee;

    public function __construct()
    {
        $this->personneConfiances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepart(): ?string
    {
        return $this->depart;
    }

    public function setDepart(string $depart): self
    {
        $this->depart = $depart;

        return $this;
    }

    public function getArrivee(): ?string
    {
        return $this->arrivee;
    }

    public function setArrivee(string $arrivee): self
    {
        $this->arrivee = $arrivee;

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

    public function getUser(): ?SimpleUser
    {
        return $this->user;
    }

    public function setUser(?SimpleUser $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|PersonneConfiance[]
     */
    public function getPersonneConfiances(): Collection
    {
        return $this->personneConfiances;
    }

    public function addPersonneConfiance(PersonneConfiance $personneConfiance): self
    {
        if (!$this->personneConfiances->contains($personneConfiance)) {
            $this->personneConfiances[] = $personneConfiance;
            $personneConfiance->setItineraire($this);
        }

        return $this;
    }

    public function removePersonneConfiance(PersonneConfiance $personneConfiance): self
    {
        if ($this->personneConfiances->removeElement($personneConfiance)) {
            // set the owning side to null (unless already changed)
            if ($personneConfiance->getItineraire() === $this) {
                $personneConfiance->setItineraire(null);
            }
        }

        return $this;
    }

    public function getLatDepart(): ?float
    {
        return $this->latDepart;
    }

    public function setLatDepart(?float $latDepart): self
    {
        $this->latDepart = $latDepart;

        return $this;
    }

    public function getLongDepart(): ?float
    {
        return $this->longDepart;
    }

    public function setLongDepart(?float $longDepart): self
    {
        $this->longDepart = $longDepart;

        return $this;
    }

    public function getLatArrivee(): ?float
    {
        return $this->latArrivee;
    }

    public function setLatArrivee(?float $latArrivee): self
    {
        $this->latArrivee = $latArrivee;

        return $this;
    }

    public function getLongArrivee(): ?float
    {
        return $this->longArrivee;
    }

    public function setLongArrivee(?float $longArrivee): self
    {
        $this->longArrivee = $longArrivee;

        return $this;
    }
}
