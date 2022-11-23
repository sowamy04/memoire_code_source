<?php

namespace App\Controller;

use App\Entity\PersonneConfiance;
use App\Repository\SimpleUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MeritoireController extends AbstractController
{
    public function __construct( EntityManagerInterface $manager){
        $this->manage = $manager;
    }
    
    /**
     * @Route(
     *  "/api/personne_confiances", 
     *  name="add_meritoire", 
     *  methods={"POST"},
     *  defaults={
     *      "_controller"="\app\ControllerPersonneConfianceController::ajouter_itinérarire",
     *      "_api_resource_class"=PersonneConfiance::class,
     *      "_api_collection_operation_name"="add_meritoire"
     *  }
     * )
     */
    public function ajouter_meritoire(Request $request, TokenStorageInterface $tokenStorage)
    {
        $req = $request->getContent();
        $requete = json_decode($req);
        $user = $tokenStorage->getToken()->getUser();
        $meritoire = new PersonneConfiance();
        $nom = $requete->nomComplet;
        $tel = $requete->telephone;
        $meritoire
            ->setSimpleUser($user)
            ->setNomComplet($nom)
            ->setTelephone($tel)
            ->setStatut(true)
            ->setDate( new \DateTime())
            ;
        
        $this->manage->persist($meritoire);
        $this->manage->flush();
        return new JsonResponse('Méritoire ajouté avec succès');
    }
}
