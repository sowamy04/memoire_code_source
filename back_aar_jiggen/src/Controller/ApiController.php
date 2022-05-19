<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Admin;
use App\Entity\Profil;
use App\Entity\SimpleUser;
use App\Service\UserService;
use App\Repository\UserRepository;
use App\Repository\AdminRepository;
use App\Repository\ProfilRepository;
use App\Repository\SimpleUserRepository;
use App\Repository\SuperAdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ApiController extends AbstractController
{
    public function __construct(UserPasswordHasherInterface $encoder, DenormalizerInterface $denormalize, 
    EntityManagerInterface $manager, ProfilRepository $profilRepository,
    SimpleUserRepository $simpleUserRepo, \Swift_Mailer $mailer, UserService $userService)
    {
        $this->dn = $denormalize;
        $this->encode = $encoder;
        $this->manage = $manager;
        $this->profilRepository = $profilRepository;
        $this->simpleUserRepo = $simpleUserRepo;
        $this->swift= $mailer;
        $this->userService = $userService;
    }

    public function sendMail($mail,  $password , $telephone){
        $message = (new \Swift_Message('Aar Jiggen / Nouveau compte'))
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
     * "api/super_admin/admins", 
     * name="ajouter_admin", 
     * methods={"POST"},
     * defaults={
     *      "_controller"="\app\ControllerApiController::ajouter_un_admin",
     *      "_api_resource_class"=Admin::class,
     *      "_api_collection_operation_name"="add_admin"
     *  }
     * )
     */
    public function ajouter_un_admin(Request $request, ProfilRepository $profilRepo)
    {
        //$em = $this->getDoctrine()->getManager();
        $requete = $request->request->all();
        $photo= $request->files->get('photo');
        $password = $requete['password'];
        $telephone = $requete['telephone'];
        $email = $requete['email'];
        if ($photo) {
            $photo= fopen($photo->getRealPath(),"rb");
        }
        $profilTab = $profilRepo->findAll();
        foreach ($profilTab as $profil) {
            if($profil->getLibelle() == "ADMIN"){
                $requete = $this->dn->denormalize($requete, Admin::class);
                $requete->setFirstConnexion(true)
                        ->setPassword($this->encode->hashPassword($requete, $password))
                        ->setProfil($profil)
                        ->setUsername($telephone)
                ;
                $requete->setStatut(true);
                $requete->setPhoto($photo);
                $this->manage->persist($requete);
                $this->manage->flush();
                $this->sendMail($email, $password, $telephone);
                return new JsonResponse("Admin ajouté avec succès!");
            }
        } 
    }

    /**
     * @Route(
     * "api/super_admin/admins/{id}", 
     * name="update_admin", 
     * methods={"POST"},
     * defaults={
     *      "_controller"="\app\ControllerApiController::modifier_admin",
     *      "_api_resource_class"=Admin::class,
     *      "_api_collection_operation_name"="put_admin"
     *  }
     * )
     */
    public function modifier_admin($id, Request $request, AdminRepository $userRepo)
    {
        $requete = $request->request->all();
        $prenom = $requete['prenom'];
        $nom = $requete['nom'];
        $email = $requete['email'];
        $password = $requete['password'];
        $telephone = $requete['telephone'];
        $photo= $request->files->get('photo');
        if ($photo) {
            $photo= fopen($photo->getRealPath(),"rb");
        }
            
            $admin = $userRepo->findOneBy(["id"=>$id]);
            $admin
                    ->setFirstConnexion(false)
                    ->setPrenom($prenom)
                    ->setNom($nom)
                    ->setTelephone($telephone)
                    ->setEmail($email)
                    ->setStatut(true)
                    ->setPhoto($photo)
                    ->setPassword($this->encode->hashPassword($admin, $password));
            ;

            $this->manage->flush();

        return new JsonResponse('Vous avez modifié vos informations avec succès');
    }

    /**
     * @Route(
     * "api/simple_users", 
     * name="ajouter_simple_user", 
     * methods={"POST"},
     * defaults={
     *      "_controller"="\app\ControllerApiController::ajouter_simple_user",
     *      "_api_resource_class"=SimpleUser::class,
     *      "_api_collection_operation_name"="add_simple_user"
     *  }
     * )
     */
    public function ajouter_simple_user(Request $request, ProfilRepository $profilRepo)
    {
        //$em = $this->getDoctrine()->getManager();
        $requete = $request->request->all();
        $photo= $request->files->get('photo');
        $password = $requete['password'];
        $telephone = $requete['telephone'];
        if ($photo) {
            $photo= fopen($photo->getRealPath(),"rb");
        }
        $profilTab = $profilRepo->findAll();
        foreach ($profilTab as $profil) {
            if($profil->getLibelle() == "USER"){
                $requete = $this->dn->denormalize($requete, SimpleUser::class);
                $requete->setPassword($this->encode->hashPassword($requete, $password))
                        ->setProfil($profil)
                        ->setUsername($telephone)
                ;
                $requete->setStatut(true);
                $requete->setPhoto($photo);
                $this->manage->persist($requete);
                $this->manage->flush();
                return new JsonResponse("Utilisateur inscrit avec succès!");
            }
        }  
    }

    /**
     * @Route(
     * "api/simple_users/{id}", 
     * name="update_simple_user", 
     * methods={"POST"},
     * defaults={
     *      "_controller"="\app\ControllerApiController::modifier_simple_user",
     *      "_api_resource_class"=SimpleUser::class,
     *      "_api_collection_operation_name"="put_simple_user"
     *  }
     * )
     */
    public function modifier_simple_user($id,Request $request, SimpleUserRepository $simpleUserRepo)
    {
        /* $requete = $request->request->all();
        $prenom = $requete['prenom'];
        $nom = $requete['nom'];
        $email = $requete['email'];
        $password = $requete['password'];
        $telephone = $requete['telephone'];
        $adresse = $requete['adresse'];
        $sexe = $requete['genre'];
        $photo= $request->files->get('photo');
        if ($photo) {
            $photo= fopen($photo->getRealPath(),"rb");
        }
            
            $user = $simpleUserRepo->findOneBy(["id"=>$id]);
            $user  ->setGenre($sexe)
                    ->setAdresse($adresse)
                    ->setPrenom($prenom)
                    ->setNom($nom)
                    ->setTelephone($telephone)
                    ->setEmail($email)
                    ->setStatut(true)
                    ->setPhoto($photo)
                    ->setPassword($this->encode->hashPassword($user, $password));
            ;

            $this->manage->flush();

        return new JsonResponse('Vous avez modifié vos informations avec succès'); */
    }


    /**
     * @Route(
     * "api/super_admins/{id}", 
     * name="update_super_admin", 
     * methods={"POST"},
     * defaults={
     *      "_controller"="\app\ControllerApiController::modifier_admin",
     *      "_api_resource_class"=User::class,
     *      "_api_collection_operation_name"="put_super_admin"
     *  }
     * )
     */
    public function modifier_super_admin($id, Request $request, SuperAdminRepository $userRepo)
    {
        $requete = $request->request->all();
        $prenom = $requete['prenom'];
        $nom = $requete['nom'];
        $email = $requete['email'];
        $password = $requete['password'];
        $telephone = $requete['telephone'];
        $photo= $request->files->get('photo');
        if ($photo) {
            $photo= fopen($photo->getRealPath(),"rb");
        }
            
            $superAdmin = $userRepo->findOneBy(["id"=>$id]);
            $superAdmin
                    ->setPrenom($prenom)
                    ->setNom($nom)
                    ->setTelephone($telephone)
                    ->setEmail($email)
                    ->setStatut(true)
                    ->setPhoto($photo)
                    ->setPassword($this->encode->hashPassword($superAdmin, $password));
            ;

            $this->manage->flush();

        return new JsonResponse('Vous avez modifié vos informations avec succès');
    }
}
