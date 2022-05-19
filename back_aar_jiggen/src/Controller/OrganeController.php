<?php

namespace App\Controller;

use App\Entity\Organe;
use App\Repository\VilleRepository;
use App\Repository\OrganeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DepartementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrganeController extends AbstractController
{
    public function __construct( EntityManagerInterface $manager){
        $this->manage = $manager;
    }
    
    /**
     * @Route(
     *  "/api/villes/organes", 
     *  name="add_organe", 
     *  methods={"POST"},
     *  defaults={
     *      "_controller"="\app\ControllerOrganeController::ajouter_organe",
     *      "_api_resource_class"=Organe::class,
     *      "_api_collection_operation_name"="add_organe"
     *  }
     * )
     */
    public function ajouter_organe(VilleRepository $villeRepo, Request $request){
        $req = $request->getContent();
        $requete = json_decode($req);
        $organe = new Organe();
        $nomOrgane = $requete->nomOrgane;
        $email = $requete->email;
        $tel = $requete->telephone;  
        $villes = $villeRepo->findAll();
        foreach ($villes as $ville) {
            if ($ville->getId() == (int)$requete->villes) {
                $organe ->setVille($ville)
                        ->setStatut(true)
                        ->setNomOrgane($nomOrgane)
                        ->setEmail($email)
                        ->setTelephone($tel)
                ;

            $this->manage->persist($organe);
            $this->manage->flush();

            return new JsonResponse('Organe ajoutée avec succès');
            }
        }
    }

     /**
     * @Route(
     *  "/api/villes/organes/{id}", 
     *  name="update_organe", 
     *  methods={"PUT"},
     *  defaults={
     *      "_controller"="\app\ControllerOrganeController::modifier_organe",
     *      "_api_resource_class"=Organe::class,
     *      "_api_collection_operation_name"="put_organe"
     *  }
     * )
     */
    public function modifier_organe(int $id, VilleRepository $villeRepo, OrganeRepository $organeRepo, Request $request){
        $organe = $organeRepo->findOneBy(["id"=>$id]);
        if(!empty($organe)){
            $req = $request->getContent();
            $requete = json_decode($req);
            $email = $requete->email;
            $tel = $requete->telephone;
            $nomOrgane = $requete->nomOrgane;
            $villes = $villeRepo->findAll();
            foreach ($villes as $ville) {
                if ($ville->getId() == (int)$requete->villes) {
                    $organe->setVille($ville)
                            ->setStatut(true)
                            ->setNomOrgane($nomOrgane)
                            ->setEmail($email)
                            ->setTelephone($tel)
                    ;
                    $this->manage->flush();

                    return new JsonResponse('Organe modifié avec succès');
                }
            } 
        }
    }
}
