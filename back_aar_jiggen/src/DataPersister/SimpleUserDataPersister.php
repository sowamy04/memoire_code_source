<?php

// src/DataPersister

namespace App\DataPersister;

use App\Entity\Profil;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\SimpleUser;

/**
 *
 */
class SimpleUserDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
    }


    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof SimpleUser;
    }

    /**
     * @param SimpleUser $data
     */
    public function persist($data, array $context = [])
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush();

       return $data;
    }

    public function remove($data, array $context = [])
    {
        $data->setStatut(false);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}