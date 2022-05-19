<?php

// src/DataPersister

namespace App\DataPersister;

use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Departement;

/**
 *
 */
class DepartementDataPersister implements ContextAwareDataPersisterInterface
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
        return $data instanceof Departement;
    }

    /**
     * @param Departement $data
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
        $villes  = $data->getVilles();
        foreach($villes as $ville) {
            $ville->setStatut(false);
            $organes = $ville->getOrganes();
            foreach ($organes as $organe) {
                $organe->setStatut(false);
            }
            $quartiers = $ville->getQuartiers();
            foreach ($quartiers as $quartier) {
                $quartier->setStatut(false);
                $avis = $quartier->getAvis();
                foreach($avis as $avi) {
                    $avi->setStatut(false);
                }
            }
        }
        $this->entityManager->flush();
    }
}