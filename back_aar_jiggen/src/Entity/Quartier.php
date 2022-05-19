<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuartierRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=QuartierRepository::class)
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
 *  "get_quartier" = {
 *   "method": "GET",
 *   "path": "/villes/quartiers/{id}",
 *   "normalization_context"={"groups":"quartier:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN') or is_granted('ROLE_USER'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 * "put_quartier" = {
*    "method": "PUT",
 *   "path": "/villes/quartiers/{id}",
 *   "normalization_context"={"groups":"quartier:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name" = "update_quartier",
 * },
 * "delete_quartier" = {
*    "method": "DELETE",
 *   "path": "/villes/quartiers/{id}",
 *   "normalization_context"={"groups":"quartier:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 * },
 *  collectionOperations = {
 * "get" = {
 *   "normalization_context"={"groups":"quartier:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN') or is_granted('ROLE_USER'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 * "lister_quartiers" = {
 *      "method": "GET",
 *   "path": "/villes/quartiers",
 *   "normalization_context"={"groups":"quartier:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN') or is_granted('ROLE_USER'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 * "add_quartier" = {
 *      "method": "POST",
 *   "path": "/villes/quartiers",
 *   "normalization_context"={"groups":"quartier:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name" = "add_quartier",
 * },
 * },
 * )
 */
class Quartier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"quartier:read", "avis:read", "simple_user:read", "ville:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"quartier:read", "avis:read", "simple_user:read", "ville:read"})
     */
    private $nomQuartier;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"quartier:read", "avis:read", "simple_user:read", "ville:read"})
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Ville::class, inversedBy="quartiers")
     * @Groups({"quartier:read"})
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity=Avis::class, mappedBy="quartier")
     * @Groups({"quartier:read"})
     */
    private $avis;

    public function __construct()
    {
        $this->avis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomQuartier(): ?string
    {
        return $this->nomQuartier;
    }

    public function setNomQuartier(string $nomQuartier): self
    {
        $this->nomQuartier = $nomQuartier;

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

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

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
            $avi->setQuartier($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getQuartier() === $this) {
                $avi->setQuartier(null);
            }
        }

        return $this;
    }
}
