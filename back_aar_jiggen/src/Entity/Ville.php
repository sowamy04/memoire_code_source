<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\VilleRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=VilleRepository::class)
 * @ApiResource(
 *  attributes = { 
 *  "input_formats"={
 *    "json"={"application/ld+json", "application/json"}
 *  }, 
 *  "output_formats"={
 *      "json"={"application/ld+json", "application/json"}
 *  } 
 * },
 *  itemOperations = {
 *  "get",
 *  "get_Ville" = {
 *   "method": "GET",
 *   "path": "/departements/villes/{id}",
 *   "normalization_context"={"groups":"ville:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 * "put_Ville" = {
 *      "method": "PUT",
 *   "path": "/departements/villes/{id}",
 *   "normalization_context"={"groups":"ville:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name" = "update_ville",
 * },
 *  "delete_Ville" = {
 *      "method": "DELETE",
 *   "path": "/departements/villes/{id}",
 *   "normalization_context"={"groups":"ville:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * }
 * },
 *  collectionOperations = {
 * "get" = {
 *   "normalization_context"={"groups":"ville:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 * "lister_Villes" = {
 *      "method": "GET",
 *   "path": "/departements/villes",
 *   "normalization_context"={"groups":"ville:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 * "add_Ville" = {
 *      "method": "POST",
 *   "path": "/departements/villes",
 *   "normalization_context"={"groups":"ville:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name" = "add_ville",
 * },
 * },
 * )
 */
class Ville
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"dept:read", "ville:read", "organe:read", "avis:read", "quartier:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"dept:read", "ville:read", "organe:read", "avis:read", "quartier:read"})
     */
    private $nomVille;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"dept:read", "ville:read", "organe:read", "avis:read", "quartier:read"})
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Departement::class, inversedBy="villes")
     * @Groups({"avis:read", "ville:read"})
     */
    private $departement;

    /**
     * @ORM\OneToMany(targetEntity=Quartier::class, mappedBy="ville")
     * @Groups({"ville:read"})
     */
    private $quartiers;

    /**
     * @ORM\OneToMany(targetEntity=Organe::class, mappedBy="ville")
     * @Groups({"ville:read"})
     */
    private $organes;

    public function __construct()
    {
        $this->quartiers = new ArrayCollection();
        $this->organes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomVille(): ?string
    {
        return $this->nomVille;
    }

    public function setNomVille(string $nomVille): self
    {
        $this->nomVille = $nomVille;

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

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * @return Collection|Quartier[]
     */
    public function getQuartiers(): Collection
    {
        return $this->quartiers;
    }

    public function addQuartier(Quartier $quartier): self
    {
        if (!$this->quartiers->contains($quartier)) {
            $this->quartiers[] = $quartier;
            $quartier->setVille($this);
        }

        return $this;
    }

    public function removeQuartier(Quartier $quartier): self
    {
        if ($this->quartiers->removeElement($quartier)) {
            // set the owning side to null (unless already changed)
            if ($quartier->getVille() === $this) {
                $quartier->setVille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Organe[]
     */
    public function getOrganes(): Collection
    {
        return $this->organes;
    }

    public function addOrgane(Organe $organe): self
    {
        if (!$this->organes->contains($organe)) {
            $this->organes[] = $organe;
            $organe->setVille($this);
        }

        return $this;
    }

    public function removeOrgane(Organe $organe): self
    {
        if ($this->organes->removeElement($organe)) {
            // set the owning side to null (unless already changed)
            if ($organe->getVille() === $this) {
                $organe->setVille(null);
            }
        }

        return $this;
    }
}
