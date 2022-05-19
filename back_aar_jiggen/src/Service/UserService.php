<?php

namespace App\Service;

use App\Entity\Profil;
use App\Repository\UserRepository;
use App\Repository\AdminRepository;
use App\Repository\ProfilRepository;
use App\Repository\ApprenantRepository;
use App\Repository\SimpleUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService {
    private $dn;
    private $encode;
    private $manage;
    private $simpleUserRepo;
    private $adminRepository;
    public function __construct(UserPasswordHasherInterface $encoder, DenormalizerInterface $denormalize, EntityManagerInterface $manager, SimpleUserRepository $simpleUserRepo, AdminRepository $adminRepository)
    {
        $this->dn = $denormalize;
        $this->encode = $encoder;
        $this->manage = $manager;
        $this->simpleUserRepo = $simpleUserRepo;
        $this->adminRepository = $adminRepository;
    }



    public function modification_user($request, $class, $id)
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
        //$pf = $requete["profil"];
        if ($class == "App\\Entity\\SimpleUser"){
            $genre = $requete['genre'];
            $adresse = $requete['adresse'];
            $simpleUser = $this->apprenantRepository->findOneBy(["id"=>$id]);
            $simpleUser->setAdresse($adresse)
                      ->setGenre($genre)
                      ->setPrenom($prenom)
                      ->setNom($nom)
                      ->setTelephone($telephone)
                      ->setEmail($email)
                      ->setStatut(true)
                      ->setPhoto($photo)
            ;
            if ($password) {
                $simpleUser->setPassword($this->encode->hashPassword($simpleUser, $password));
             }
        }
        else{
            $user = $this->adminRepository->findOneBy(["id"=>$id]);
            $user
                ->setFirstConnexion(false)
                ->setPrenom($prenom)
                ->setNom($nom)
                ->setTelephone($telephone)
                ->setEmail($email)
                ->setStatut(true)
                ->setPhoto($photo)
            ;
            if ($password) {
               $user->setPassword($this->encode->hashPassword($user, $password));
            }
        }
        $this->manage->flush();
        return true;
    }

    
}