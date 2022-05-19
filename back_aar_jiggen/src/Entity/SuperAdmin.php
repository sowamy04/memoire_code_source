<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\SuperAdminRepository;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=SuperAdminRepository::class)
 * @ApiResource(
 *  collectionOperations = {
 *   "get" 
 * },
 * itemOperations = {
 *   "get_super_admin" = {
 *    "method": "GET",
 *   "path": "/super_admins/{id}",
 *   "normalization_context"={"groups":"super_admin:read"},
 *   "security"="(is_granted('ROLE_SUPER_ADMIN'))",
 *   },
 *  }
 * )
 */
class SuperAdmin extends User
{
}
