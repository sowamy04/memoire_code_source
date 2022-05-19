<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DepartementRepository::class)
 * @ApiResource(
 *  attributes = { 
 *  "input_formats"={
 *    "json"={"application/ld+json", "application/json"}
 *  }, 
 *  "output_formats"={
 *      "json"={"application/ld+json", "application/json"}
 *  } 
 * },
 * itemOperations = {
 * "get",
 *  "afficher_dept" = {
 *   "method": "GET",
 *   "path": "/regions/departements/{id}",
 *   "normalization_context"={"groups":"dept:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource"
 * },
 * "put_dept" = {
 *   "method": "PUT",
 *   "path": "/regions/departements/{id}",
 *   "normalization_context"={"groups":"dept:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name" = "update_dept",
 * },
 *  "delete_dept" = {
 *   "method": "DELETE",
 *   "path": "/regions/departements/{id}",
 *   "normalization_context"={"groups":"dept:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * }
 * },
 *  collectionOperations = {
 *  "lister_depts" = {
 *   "method": "GET",
 *   "path": "/regions/departements",
 *   "normalization_context"={"groups":"dept:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN') or is_granted('ROLE_SIMPLE_USER'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 * "add_dept" = {
 *   "method": "POST",
 *   "path": "/regions/departements",
 *   "normalization_context"={"groups":"dept:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name" = "add_dept",
 * },
 * },
 * )
 */
class Departement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"region:read", "dept:read", "avis:read", "ville:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"region:read", "dept:read", "avis:read", "ville:read"})
     */
    private $nomDept;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"region:read", "dept:read", "avis:read", "ville:read"})
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Region::class, inversedBy="departements")
     * @Groups({"avis:read", "dept:read"})
     */
    private $region;

    /**
     * @ORM\OneToMany(targetEntity=Ville::class, mappedBy="departement")
     * @Groups({"dept:read"})
     */
    private $villes;

    public function __construct()
    {
        $this->villes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDept(): ?string
    {
        return $this->nomDept;
    }

    public function setNomDept(string $nomDept): self
    {
        $this->nomDept = $nomDept;

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

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection|Ville[]
     */
    public function getVilles(): Collection
    {
        return $this->villes;
    }

    public function addVille(Ville $ville): self
    {
        if (!$this->villes->contains($ville)) {
            $this->villes[] = $ville;
            $ville->setDepartement($this);
        }

        return $this;
    }

    public function removeVille(Ville $ville): self
    {
        if ($this->villes->removeElement($ville)) {
            // set the owning side to null (unless already changed)
            if ($ville->getDepartement() === $this) {
                $ville->setDepartement(null);
            }
        }

        return $this;
    }
}
