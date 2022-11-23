<?php

namespace App\Controller;

use App\Entity\CoordonneesGeographiques;
use App\Repository\SimpleUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\CoordonneesGeographiquesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CoordonneesGeographiquesController extends AbstractController
{
    public function __construct( EntityManagerInterface $manager){
        $this->manage = $manager;
    }
        
    /**
     * @Route(
     *  "/api/coordonnees_geographiques", 
     *  name="add_coordonnees", 
     *  methods={"POST"},
     *  defaults={
     *      "_controller"="\app\ControllerCoordonneesGeographiquesController::ajouter_coordonnees",
     *      "_api_resource_class"=CoordonneesGeographiques::class,
     *      "_api_collection_operation_name"="add_coordonnees"
     *  }
     * )
     */
    public function ajouter_coordonnees(Request $request, TokenStorageInterface $tokenStorage)
    {
        $req = $request->getContent();
        $requete = json_decode($req);
        $user = $tokenStorage->getToken()->getUser();
        $coordonnees = new CoordonneesGeographiques();
        $lat = $requete->lattitude;
        $long = $requete->longitude;
        $date = new \DateTime();
        $coordonnees
            ->setUser($user)
            ->setLatitude($lat)
            ->setLongitude($long)
            ->setDate($date)
            ;
        
        $this->manage->persist($coordonnees);
        $this->manage->flush();
        return new JsonResponse('Coordonnées enregistrées avec succès');
    }
}
