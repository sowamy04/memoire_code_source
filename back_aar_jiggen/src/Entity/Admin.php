<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdminRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
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
 * "get_all_admins" = {
 *    "method": "GET",
 *   "path": "/super_admin/admins",
 *   "normalization_context"={"groups":"admin:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 * "add_admin" = {
 *    "method": "POST",
 *   "path": "/super_admin/admins",
 *   "normalization_context"={"groups":"admin:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name" = "ajouter_admin",
 * },
 *  },
 *  itemOperations ={
 *   "get_admin" = {
 *    "method": "GET",
 *   "path": "/super_admin/admins/{id}",
 *   "normalization_context"={"groups":"admin:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   },
 * "delete_admin" = {
 *    "method": "DELETE",
 *   "path": "/super_admin/admins/{id}",
 *   "normalization_context"={"groups":"admin:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   },
 *  "put_admin" = {
 *    "method": "POST",
 *   "path": "/super_admin/admins/{id}",
 *   "normalization_context"={"groups":"admin:read"},
 *   "access_control"="(is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name" = "update_admin",
 *   },
 *  }
 * )
 */
class Admin extends User
{
    /**
     * @ORM\Column(type="boolean")
     * @Groups({"admin:read"})
     */
    private $firstConnexion;

    public function getFirstConnexion(): ?bool
    {
        return $this->firstConnexion;
    }

    public function setFirstConnexion(bool $firstConnexion): self
    {
        $this->firstConnexion = $firstConnexion;

        return $this;
    }
}
