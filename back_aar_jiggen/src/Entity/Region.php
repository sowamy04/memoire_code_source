<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RegionRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=RegionRepository::class)
 * @ApiResource(
 *  itemOperations = {
 *  "get_region" = {
 *   "method": "GET",
 *   "path": "/regions/{id}",
 *   "normalization_context"={"groups":"region:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 * "put_region" = {
 *      "method": "PUT",
 *   "path": "/regions/{id}",
 *   "normalization_context"={"groups":"region:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 *  "delete_region" = {
 *      "method": "DELETE",
 *   "path": "/regions/{id}",
 *   "normalization_context"={"groups":"region:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  }
 *  },
 * collectionOperations = {
 *  "get_regions" = {
 *      "method": "GET",
 *   "path": "/regions",
 *   "normalization_context"={"groups":"region:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 * "add_region" = {
 *      "method": "POST",
 *   "path": "/regions",
 *   "normalization_context"={"groups":"region:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 * }

 * )
 */
class Region
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"region:read", "avis:read", "dept:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"region:read", "avis:read", "dept:read"})
     */
    private $nomRegion;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"region:read", "avis:read", "dept:read"})
     */
    private $statut = true;

    /**
     * @ORM\OneToMany(targetEntity=Departement::class, mappedBy="region")
     * @Groups({"region:read"})
     */
    private $departements;

    public function __construct()
    {
        $this->departements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRegion(): ?string
    {
        return $this->nomRegion;
    }

    public function setNomRegion(string $nomRegion): self
    {
        $this->nomRegion = $nomRegion;

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

    /**
     * @return Collection|Departement[]
     */
    public function getDepartements(): Collection
    {
        return $this->departements;
    }

    public function addDepartement(Departement $departement): self
    {
        if (!$this->departements->contains($departement)) {
            $this->departements[] = $departement;
            $departement->setRegion($this);
        }

        return $this;
    }

    public function removeDepartement(Departement $departement): self
    {
        if ($this->departements->removeElement($departement)) {
            // set the owning side to null (unless already changed)
            if ($departement->getRegion() === $this) {
                $departement->setRegion(null);
            }
        }

        return $this;
    }
}
