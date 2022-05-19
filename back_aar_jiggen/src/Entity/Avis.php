<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AvisRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AvisRepository::class)
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
 *    "normalization_context"={"groups":"avis:read"},
 *    "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN') or is_granted('ROLE_USER'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource"
 *   },
 * "lister_avis" = {
 *    "method": "GET",
 *    "path": "simple_users/avis", 
 *    "normalization_context"={"groups":"avis:read"},
 *    "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN') or is_granted('ROLE_USER'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource"
 * },
 * "add_avis" = {
 *    "method": "POST",
 *   "path": "/simple_users/avis", 
 *   "normalization_context"={"groups":"avis:read"},
 *   "access_control"="(is_granted('ROLE_USER'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name"="add_avis",
 *   "validate"=false,
 * },
 * },
 * itemOperations= {
 *  "get_avis" = {
 *    "method": "GET",
 *   "path": "/simple_users/avis/{id}",
 *   "normalization_context"={"groups":"avis:read"},
 *   "access_control"="(is_granted('ROLE_USER') or is_granted('ROLE_ADMIN') or is_granted('ROLE_SUPER_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource"
 *  },
 * }
 * )
 */
class Avis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"avis:read", "simple_user:read", "quartier:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"avis:read", "simple_user:read", "quartier:read"})
     */
    private $eclairagePublique;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"avis:read", "simple_user:read", "quartier:read"})
     */
    private $vol;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"avis:read", "simple_user:read", "quartier:read"})
     */
    private $viol;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"avis:read", "simple_user:read", "quartier:read"})
     */
    private $agression;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"avis:read", "simple_user:read", "quartier:read"})
     */
    private $transport;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"avis:read", "simple_user:read", "quartier:read"})
     */
    private $qualiteRoute;

    /**
     * @ORM\Column(type="text")
     * @Groups({"avis:read", "simple_user:read", "quartier:read"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=SimpleUser::class, inversedBy="avis")
     * @Groups({"avis:read"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Quartier::class, inversedBy="avis")
     * @Groups({"avis:read", "simple_user:read"})
     */
    private $quartier;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"avis:read", "simple_user:read", "quartier:read"})
     */
    private $statut;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEclairagePublique(): ?int
    {
        return $this->eclairagePublique;
    }

    public function setEclairagePublique(int $eclairagePublique): self
    {
        $this->eclairagePublique = $eclairagePublique;

        return $this;
    }

    public function getVol(): ?int
    {
        return $this->vol;
    }

    public function setVol(int $vol): self
    {
        $this->vol = $vol;

        return $this;
    }

    public function getViol(): ?int
    {
        return $this->viol;
    }

    public function setViol(int $viol): self
    {
        $this->viol = $viol;

        return $this;
    }

    public function getAgression(): ?int
    {
        return $this->agression;
    }

    public function setAgression(int $agression): self
    {
        $this->agression = $agression;

        return $this;
    }

    public function getTransport(): ?int
    {
        return $this->transport;
    }

    public function setTransport(int $transport): self
    {
        $this->transport = $transport;

        return $this;
    }

    public function getQualiteRoute(): ?string
    {
        return $this->qualiteRoute;
    }

    public function setQualiteRoute(string $qualiteRoute): self
    {
        $this->qualiteRoute = $qualiteRoute;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getQuartier(): ?Quartier
    {
        return $this->quartier;
    }

    public function setQuartier(?Quartier $quartier): self
    {
        $this->quartier = $quartier;

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
}
