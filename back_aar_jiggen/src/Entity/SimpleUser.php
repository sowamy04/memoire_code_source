<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\SimpleUserRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SimpleUserRepository::class)
 * @ApiResource(
 *  attributes={
 *      "input_formats"={"json"={"application/ld+json", "application/json"}},
 *      "output_formats"={"json"={"application/ld+json", "application/json"}},
 *      "deserialize"=false,
 *        "swagger_context"={
 *           "consumes"={
 *              "multipart/form-data",
 *             },
 *             "parameters"={
 *                "in"="formData",
 *                "name"="file",
 *                "type"="file",
 *                "description"="The file to upload",
 *              },
*           },
 *     },
 *  collectionOperations ={
 * "get_all_simple_users" = {
 *    "method": "GET",
 *   "path": "/simple_users",
 *   "normalization_context"={"groups":"simple_user:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 * "add_simple_user" = {
 *    "method": "POST",
 *   "path": "/simple_users",
 *   "normalization_context"={"groups":"simple_users:read"},
 *   "route_name" = "ajouter_simple_user",
 * },
 *  },
 *  itemOperations ={
 *   "get_simple_user" = {
 *    "method": "GET",
 *   "path": "/simple_users/{id}",
 *   "normalization_context"={"groups":"simple_user:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN') or is_granted('ROLE_USER'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   },
 * "put_simple_user" = {
 *    "method": "POST",
 *   "path": "/simple_users/{id}",
 *   "normalization_context"={"groups":"simple_user:read"},
 *   "access_control"="(is_granted('ROLE_USER') or is_granted('ROLE_SUPER_ADMIN))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name" = "update_simple_user",
 *   },
 * "delete_simple_user" = {
 *    "method": "DELETE",
 *   "path": "/simple_users/{id}",
 *   "normalization_context"={"groups":"simple_user:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   },
 *  "get_itineraires_user" = {
 *    "method": "GET",
 *   "path": "/simple_users/{id}/itineraires",
 *   "normalization_context"={"groups":"simple_user:read"},
 *   "access_control"="(is_granted('ROLE_USER') or is_granted('ROLE_ADMIN') or is_granted('ROLE_SUPER_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource"
 *  },
 *  }
 * )
 */
class SimpleUser extends User
{ 
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"simple_user:read", "meritoire:read", "itineraire:read", "coordonnees:read", "alerte:read", "avis:read"})
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"simple_user:read", "meritoire:read", "itineraire:read", "coordonnees:read", "alerte:read", "avis:read"})
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity=Avis::class, mappedBy="user")
     * @Groups({"simple_user:read"})
     */
    private $avis;

    /**
     * @ORM\OneToMany(targetEntity=PersonneConfiance::class, mappedBy="simpleUser")
     * @Groups({"simple_user:read"})
     */
    private $personneConfiances;

    /**
     * @ORM\OneToMany(targetEntity=Itineraire::class, mappedBy="user")
     * @Groups({"simple_user:read"})
     */
    private $itineraires;

    /**
     * @ORM\OneToMany(targetEntity=CoordonneesGeographiques::class, mappedBy="user")
     */
    private $coordonneesGeographiques;

    /**
     * @ORM\OneToMany(targetEntity=Alerte::class, mappedBy="simpleUser")
     * @Groups({"simple_user:read"})
     */
    private $alertes;

    public function __construct()
    {
        $this->avis = new ArrayCollection();
        $this->personneConfiances = new ArrayCollection();
        $this->itineraires = new ArrayCollection();
        $this->coordonneesGeographiques = new ArrayCollection();
        $this->alertes = new ArrayCollection();
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection|Avis[]
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis[] = $avi;
            $avi->setUser($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getUser() === $this) {
                $avi->setUser(null);
            }
        }

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
            $personneConfiance->setSimpleUser($this);
        }

        return $this;
    }

    public function removePersonneConfiance(PersonneConfiance $personneConfiance): self
    {
        if ($this->personneConfiances->removeElement($personneConfiance)) {
            // set the owning side to null (unless already changed)
            if ($personneConfiance->getSimpleUser() === $this) {
                $personneConfiance->setSimpleUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Itineraire[]
     */
    public function getItineraires(): Collection
    {
        return $this->itineraires;
    }

    public function addItineraire(Itineraire $itineraire): self
    {
        if (!$this->itineraires->contains($itineraire)) {
            $this->itineraires[] = $itineraire;
            $itineraire->setUser($this);
        }

        return $this;
    }

    public function removeItineraire(Itineraire $itineraire): self
    {
        if ($this->itineraires->removeElement($itineraire)) {
            // set the owning side to null (unless already changed)
            if ($itineraire->getUser() === $this) {
                $itineraire->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CoordonneesGeographiques[]
     */
    public function getCoordonneesGeographiques(): Collection
    {
        return $this->coordonneesGeographiques;
    }

    public function addCoordonneesGeographique(CoordonneesGeographiques $coordonneesGeographique): self
    {
        if (!$this->coordonneesGeographiques->contains($coordonneesGeographique)) {
            $this->coordonneesGeographiques[] = $coordonneesGeographique;
            $coordonneesGeographique->setUser($this);
        }

        return $this;
    }

    public function removeCoordonneesGeographique(CoordonneesGeographiques $coordonneesGeographique): self
    {
        if ($this->coordonneesGeographiques->removeElement($coordonneesGeographique)) {
            // set the owning side to null (unless already changed)
            if ($coordonneesGeographique->getUser() === $this) {
                $coordonneesGeographique->setUser(null);
            }
        }

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
            $alerte->setSimpleUser($this);
        }

        return $this;
    }

    public function removeAlerte(Alerte $alerte): self
    {
        if ($this->alertes->removeElement($alerte)) {
            // set the owning side to null (unless already changed)
            if ($alerte->getSimpleUser() === $this) {
                $alerte->setSimpleUser(null);
            }
        }

        return $this;
    }

    
}
