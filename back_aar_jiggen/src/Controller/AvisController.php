<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Repository\AvisRepository;
use App\Repository\VilleRepository;
use App\Repository\QuartierRepository;
use App\Repository\SimpleUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\Serializer\JsonEncoder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AvisController extends AbstractController
{
    private $dn;
    public function __construct(DenormalizerInterface $denormalizerInterface, EntityManagerInterface $manager)
    {
        $this->dn  = $denormalizerInterface;
        $this->manage = $manager;
    }

    /**
     * @Route(
     *  "/api/avis", 
     *  name="add_avis", 
     *  methods={"POST"},
     *  defaults={
     *      "_controller"="\app\ControllerAvisController::ajouter_avis",
     *      "_api_resource_class"=Avis::class,
     *      "_api_collection_operation_name"="add_avis"
     *  }
     * )
     */
    public function ajouter_avis(Request $request, QuartierRepository $quartierRepo, TokenStorageInterface $tokenStorage)
    {
        $req = $request->getContent();
        $requete = json_decode($req);
        $user = $tokenStorage->getToken()->getUser();
        $avis = new Avis();
        $eclairage = $requete->eclairagePublique;
        $vol = $requete->vol;
        $transport = $requete->transport;
        $agression = $requete->agression;
        $quartiers = $quartierRepo->findAll();
        foreach ($quartiers as $quartier) {
            if ($quartier->getId() == (int)$requete->quartiers) {
                $avis
                ->setUser($user)
                ->setEclairagePublique((int)$eclairage)
                ->setVol((int)$vol)
                ->setTransport((int)$transport)
                ->setAgression((int)$agression)
                ->setDescription($requete->description)
                ->setQuartier($quartier)
                ->setStatut(true)
                ->setViol((int)$requete->viol)
                ->setQualiteRoute($requete->qualiteRoute)
                ;
                $this->manage->persist($avis);
                $this->manage->flush();
                return new JsonResponse('avis enregistré avec succès');
            }
        }
        return new JsonResponse("Quartier inexistant, veuillez en choisir un autre svp!");
    }

     /**
     * @Route(
     *  "/api/simple_users/villes/{id}/avis", 
     *  name="niveau_insecurite", 
     *  methods={"GET"},
     *  defaults={
     *      "_controller"="\app\ControllerAvisController::ville_dangereuse",
     *      "_api_resource_class"=Avis::class,
     *      "_api_collection_operation_name"="get_niveau_insecurite"
     *  }
     * )
     */
    /* public function ville_dangereuse(int $id, VilleRepository $villeRepo, AvisRepository $avisRepo, Request $request)
    {
        $ville = $villeRepo->findOneBy(["id"=>$id]);
        $eclairage = 0;
        $vol = 0;
        $agression = 0;
        $transport = 0;
        $n = 0;
        if (!empty($ville)) {
            $avis = $avisRepo->findAll();
            foreach ($avis as $un_avis) {
                if ($un_avis->getVilles()->getId() == $id) {
                    $eclairage += $un_avis->getEclairagePublique();

                    $vol += $un_avis->getVol();
                    $agression += $un_avis->getAgression();
                    $transport += $un_avis->getTransport();
                    $n++;
                }
            }
            $niveau_insecurite = ($eclairage + $vol + $agression + $transport)/(5*$n);
            if ($niveau_insecurite<=2) {
                return $this->json('Cette ville n\'est pas securisé');
            }
            else {
                return $this->json('Cette ville est securisé');
            }
        }
    } */
}
