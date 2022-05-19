<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrganeRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OrganeRepository::class)
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
 *  "get_organe" = {
 *   "method": "GET",
 *   "path": "/villes/organes/{id}",
 *   "normalization_context"={"groups":"organe:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 * "put_organe" = {
 *      "method": "PUT",
 *   "path": "/villes/organes/{id}",
 *   "normalization_context"={"groups":"organe:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name" = "update_organe",
 * },
 *  "delete_organe" = {
 *      "method": "DELETE",
 *   "path": "/villes/organes/{id}",
 *   "normalization_context"={"groups":"organe:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource"
 * }
 * },
 *  collectionOperations = {
 *  "get"={
 *   "normalization_context"={"groups":"organe:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 * "lister_organes" = {
 *      "method": "GET",
 *   "path": "/villes/organes",
 *   "normalization_context"={"groups":"organe:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 * "add_organe" = {
 *      "method": "POST",
 *   "path": "/villes/organes",
 *   "normalization_context"={"groups":"organe:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name" = "add_organe",
 * },
 * },
 * )
 */
class Organe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"ville:read", "organe:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"ville:read", "organe:read"})
     */
    private $nomOrgane;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"ville:read", "organe:read"})
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"ville:read", "organe:read"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"ville:read", "organe:read"})
     */
    private $telephone;

    /**
     * @ORM\ManyToOne(targetEntity=Ville::class, inversedBy="organes")
     * @Groups({"organe:read"})
     */
    private $ville;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomOrgane(): ?string
    {
        return $this->nomOrgane;
    }

    public function setNomOrgane(string $nomOrgane): self
    {
        $this->nomOrgane = $nomOrgane;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }
}
