<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\CoordonneesGeographiquesRepository;

/**
 * @ORM\Entity(repositoryClass=CoordonneesGeographiquesRepository::class)
 * @ApiResource(
 *   attributes={ 
 *  "input_formats"={
 *    "json"={"application/ld+json", "application/json"}
 *  }, 
 *  "output_formats"={
 *      "json"={"application/ld+json", "application/json"}
 *  } 
 * },
 *  collectionOperations ={
 *  "get"= {
 *    "normalization_context"={"groups":"coordonnees:read"},
 *    "access_control"="(is_granted('ROLE_SUPER_ADMIN'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource"
 *   },
 * "lister_coordonnees_geographiques" = {
 *    "method": "GET",
 *    "path": "simple_users/coordonnees_geographiques", 
 *    "normalization_context"={"groups":"coordonnees:read"},
 *    "access_control"="(is_granted('ROLE_SUPER_ADMIN'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource"
 * },
 * "add_coordonnees" = {
 *    "method": "POST",
 *   "path": "/coordonnees_geographiques", 
 *   "normalization_context"={"groups":"coordonnees:read"},
 *   "access_control"="(is_granted('ROLE_USER'))",
 *   "access_control_message"="Vous n'avez pas access à cetteThe Ressource",
 *   "route_name"="add_coordonnees",
 * },
 * },
 * itemOperations= {
 *  "get_coordonnees" = {
 *    "method": "GET",
 *   "path": "/simple_users/coordonnees_geographiques/{id}",
 *   "normalization_context"={"groups":"coordonnees:read"},
 *   "access_control"="(is_granted('ROLE_USER') or is_granted('ROLE_ADMIN') or is_granted('ROLE_SUPER_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource"
 *  },
 * }
 * )
 */
class CoordonneesGeographiques
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"coordonnees:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"coordonnees:read"})
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=SimpleUser::class, inversedBy="coordonneesGeographiques")
     * @Groups({"coordonnees:read"})
     */
    private $user;

    /**
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     */
    private $longitude;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }
}
