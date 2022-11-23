<?php

namespace App\Controller;

use App\Entity\Quartier;
use App\Repository\VilleRepository;
use App\Repository\QuartierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuartierController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager, \Swift_Mailer $mailer)
    {
        $this->manage = $manager;
        $this->swift= $mailer;
    }

    public function sendMail($mail,  $password , $telephone){
        $message = (new \Swift_Message('Aar Jiggen / Informations quartiers'))
                ->setFrom('amysow0495@gmail.com')
                ->setTo($mail)
                ->setBody(
                    $this->renderView(
                        'api/index.html.twig',
                        [
                            'telephone'=> $telephone,
                            'password'=>$password
                        ]
                        ),
                        'text/html'
        );
        $this->swift->send($message);
    }
    
    /**
     * @Route(
     *  "/api/villes/quartiers", 
     *  name="add_quartier", 
     *  methods={"POST"},
     *  defaults={
     *      "_controller"="\app\ControllerQuartierController::ajouter_quartier",
     *      "_api_resource_class"=Quartier::class,
     *      "_api_collection_operation_name"="add_quartier"
     *  }
     * )
     */
    public function ajouter_quartier(VilleRepository $villeRepo, Request $request){
        $req = $request->getContent();
        $requete = json_decode($req);
        $quartier = new Quartier();
        $nomQuartier = $requete->nomQuartier;   
        $villes = $villeRepo->findAll();
        foreach ($villes as $ville) {
            if ($ville->getId() == (int)$requete->villes) {
                $quartier->setVille($ville)
                     ->setNomQuartier($nomQuartier)
                     ->setStatut(true)
                ;

                $this->manage->persist($quartier);
                $this->manage->flush();

                return new JsonResponse('quartier ajoutée avec succès');
            }
        }
    }

     /**
     * @Route(
     *  "/api/villes/quartiers/{id}", 
     *  name="update_quartier", 
     *  methods={"PUT"},
     *  defaults={
     *      "_controller"="\app\ControllerQuartierController::modifier_quartier",
     *      "_api_resource_class"=Quartier::class,
     *      "_api_collection_operation_name"="put_quartier"
     *  }
     * )
     */
    public function modifier_quartier(int $id, QuartierRepository $quartierRepo, VilleRepository $villeRepo, Request $request){
        $quartier = $quartierRepo->findOneBy(["id"=>$id]);
        if(!empty($quartier)){
            $req = $request->getContent();
            $requete = json_decode($req);
            $nomQuartier = $requete->nomQuartier;
            $villes = $villeRepo->findAll();
            foreach ($villes as $ville) {
                if ($ville->getId() == (int)$requete->villes) {
                    $quartier->setVille($ville)
                            ->setNomQuartier($nomQuartier)
                            ->setStatut(true)
                        ;
                    $this->manage->flush();
                    return new JsonResponse('Quartier modifié avec succès');
                    
                }
            }    
        }
    }

    /**
     * @Route(
     *  "/api/villes/quartiers/{id}/alertes", 
     *  name="send_alerte", 
     *  methods={"POST"},
     *  defaults={
     *      "_controller"="\app\ControllerQuartierController::sendAlertes",
     *      "_api_resource_class"=Quartier::class,
     *      "_api_collection_operation_name"="send_alerte"
     *  }
     * )
     */
    public function sendAlertes(Request $request){
        $requete = json_decode($request->getContent());
        $quartier = $this->manage->getRepository(Quartier::class)->findOneBy(['id' => intval($requete->quartier)]);
        $avis = $quartier->getAvis();
        dd($avis);
    }
}
