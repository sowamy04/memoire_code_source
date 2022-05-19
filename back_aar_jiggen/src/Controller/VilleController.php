<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DepartementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VilleController extends AbstractController
{
    public function __construct( EntityManagerInterface $manager){
        $this->manage = $manager;
    }
    
    /**
     * @Route(
     *  "/api/departements/villes", 
     *  name="add_ville", 
     *  methods={"POST"},
     *  defaults={
     *      "_controller"="\app\ControllerVilleController::ajouter_ville",
     *      "_api_resource_class"=Ville::class,
     *      "_api_collection_operation_name"="add_Ville"
     *  }
     * )
     */
    public function ajouter_ville(DepartementRepository $detpRepo, Request $request){
        $req = $request->getContent();
        $requete = json_decode($req);
        $ville = new Ville();
        $nomVille = $requete->nomVille;   
        $departements = $detpRepo->findAll();
        foreach ($departements as $departement) {
            if ($departement->getId() == (int)$requete->depts) {
                $ville->setDepartement($departement)
                     ->setNomVille($nomVille)
                     ->setStatut(true)
                ;

                $this->manage->persist($ville);
                $this->manage->flush();

                return new JsonResponse('Ville ajoutée avec succès');
            }
        }
    }

     /**
     * @Route(
     *  "/api/departements/villes/{id}", 
     *  name="update_ville", 
     *  methods={"PUT"},
     *  defaults={
     *      "_controller"="\app\ControllerVilleController::modifier_ville",
     *      "_api_resource_class"=Ville::class,
     *      "_api_collection_operation_name"="put_Ville"
     *  }
     * )
     */
    public function modifier_ville(int $id, DepartementRepository $deptRepo, VilleRepository $villeRepo, Request $request){
        $ville = $villeRepo->findOneBy(["id"=>$id]);
        if(!empty($ville)){
            $req = $request->getContent();
            $requete = json_decode($req);
            $nomVille = $requete->nomVille;
            $departements = $deptRepo->findAll();
            foreach ($departements as $departement) {
                if ($departement->getId() == (int)$requete->depts) {
                    $ville->setDepartement($departement)
                        ->setNomVille($nomVille)
                        ->setStatut(true)
                    ;
                    $this->manage->flush();

                    return new JsonResponse('Département modifié avec succès');
                    
                }
            }    
        }
    }
}
