<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Repository\RegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DepartementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DepartementController extends AbstractController
{
    public function __construct( EntityManagerInterface $manager){
        $this->manage = $manager;
    }
    
    /**
     * @Route(
     *  "/api/regions/departements", 
     *  name="add_dept", 
     *  methods={"POST"},
     *  defaults={
     *      "_controller"="\app\ControllerDepartementController::ajouter_dept",
     *      "_api_resource_class"=Departement::class,
     *      "_api_collection_operation_name"="add_dept"
     *  }
     * )
     */
    public function ajouter_dept(RegionRepository $regionRepo, Request $request)
    {
        $req = $request->getContent();
        $requete = json_decode($req);
        $dept = new Departement();
        $nomDept = $requete->nomDept;   
        $regions = $regionRepo->findAll();
        foreach ($regions as $region) {
            if ($region->getId() == (int)$requete->regions) {
                $dept->setRegion($region)
                     ->setNomDept($nomDept)
                ;

                $this->manage->persist($dept);
                $this->manage->flush();

                return new JsonResponse('Département ajouté avec succès');
            }
        }
        
    }

    /**
     * @Route(
     *  "/api/regions/departements/{id}", 
     *  name="update_dept", 
     *  methods={"PUT"},
     *  defaults={
     *      "_controller"="\app\ControllerDepartementController::modifier_dept",
     *      "_api_resource_class"=Departement::class,
     *      "_api_collection_operation_name"="put_dept"
     *  }
     * )
     */
    public function modifier_dept(int $id, DepartementRepository $deptRepo, Request $request, RegionRepository $regionRepo)
    {
        $departement = $deptRepo->findOneBy(["id"=>$id]);
        if(!empty($departement)){
            $req = $request->getContent();
            $requete = json_decode($req);
            $nomDept = $requete->nomDept;
            $regions = $regionRepo->findAll();
            foreach ($regions as $region) {
                if ($region->getId() == (int)$requete->regions) {
                    $departement->setRegion($region)
                                ->setNomDept($nomDept)
                    ;
                    $this->manage->flush();

                    return new JsonResponse('Département ajouté avec succès');
                    
                }
            }    
        }
    }
}
