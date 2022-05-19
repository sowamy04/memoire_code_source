<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Admin;
use App\Entity\Ville;
use App\Entity\Profil;
use App\Entity\Region;
use App\Entity\SimpleUser;
use App\Entity\SuperAdmin;
use App\Entity\Departement;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordHasherInterface $encoder, EntityManagerInterface $manager)
    {
      $this->encoder=$encoder;
      $this->manage = $manager;
    }

    public function load(ObjectManager $manager)
    {
        $faker= Factory::create();
        $profils =["SUPER_ADMIN" ,"ADMIN" ,"USER"];  
        
        foreach ($profils as $key => $libelle) {
            $profil =new Profil() ;
            $profil->setLibelle ($libelle )
                   ->setStatut(true)
            ;
            $manager->persist ($profil );
            $manager->flush();

            if($profil->getLibelle() == "SUPER_ADMIN"){
                  $super_admin = new SuperAdmin() ;
                  $password = $this->encoder->hashPassword ($super_admin, 'pass1234' );
                  $super_admin
                        ->setProfil ($profil )
                        ->setUsername (strtolower ($libelle ))
                        ->setPassword($password )
                        ->setPrenom("Amy")
                        ->setNom("SOW")
                        ->setEmail("amysow04@gmail.com")
                        ->setTelephone("774887764")
                        ->setStatut(true)
                        ;
                  $manager->persist($super_admin);
                  
            }

            if($profil->getLibelle()  == "USER"){
                  for ($i=1; $i <=2 ; $i++) {
                  $user = new SimpleUser() ;
                  $password = $this->encoder->hashPassword ($user, 'pass1234' );
                  $user->setAdresse($faker->address)
                        ->setGenre($faker->randomElement($array = array ('homme', 'femme')))
                        ->setProfil ($profil )
                        ->setUsername (strtolower ($libelle ).$i)
                        ->setPassword($password )
                        ->setPrenom($faker->firstName())
                        ->setNom($faker->lastName)
                        ->setEmail($faker->email)
                        ->setTelephone($faker->phoneNumber)
                        ->setStatut(true)
                        ;
                  $manager->persist($user);
                  }
            }

            if($profil->getLibelle()  == "ADMIN"){
                  for ($i=1; $i <=2 ; $i++) {
                  $admin = new Admin() ;
                  $password = $this->encoder->hashPassword ($admin, 'pass1234' );
                  $admin->setFirstConnexion(true)
                        ->setProfil ($profil )
                        ->setUsername (strtolower ($libelle ).$i)
                        ->setPassword($password )
                        ->setPrenom($faker->firstName())
                        ->setNom($faker->lastName)
                        ->setEmail($faker->email)
                        ->setTelephone($faker->phoneNumber)
                        ->setStatut(true)
                        ;
                  $manager->persist($admin);
                  }
            }
        }

        $regions = [ "Dakar", "Diourbel", "Fatick", "Kaffrine", "Kaolack", 
        "Kédougou", "Kolda", "Louga", "Matam", "Saint-Louis", "Sédhiou", 
        "Tambacounda", "Thiès", "Ziguinchor" ];
        foreach ($regions as $key => $region) {
            $rg = new Region();
            $rg->setNomRegion($region)
               ->setStatut(true);
            $manager->persist($rg);
            $manager->flush();

            if ($region == "Dakar"){
                $dept1 = new Departement();
                $dept2 = new Departement();
                $dept3 = new Departement();
                $dept4 = new Departement();
                $dept5 = new Departement();
                $dept1->setRegion($rg)
                      ->setNomDept("Dakar")
                      ->setStatut(true)
                ;
                $dept2->setRegion($rg)
                      ->setNomDept("Guédiwaye")
                      ->setStatut(true)
                ;
                $dept3->setRegion($rg)
                      ->setNomDept("Pikine")
                      ->setStatut(true)
                ;
                $dept4->setRegion($rg)
                      ->setNomDept("Rufisque")
                      ->setStatut(true)
                ;
                $dept5->setRegion($rg)
                      ->setNomDept("Keur Massar")
                      ->setStatut(true)
                ;
                $manager->persist($dept1);
                $manager->persist($dept2);
                $manager->persist($dept3);
                $manager->persist($dept4);
                $manager->persist($dept5);

                $villes1 = ["Mermoz-Sacré-Cœur", "Ngor", "Ouakam", "Yoff", "Dakar-Plateau", "Fann-Point E-Amitié", "Gueule Tapée-Fass-Colobane", "Médina","Biscuiterie", "Dieuppeul-Derklé", "Grand Dakar", "Hann Bel-Air", "HLM", "Sicap-Liberté","Cambérène", "Grand Yoff", "Parcelles Assainies", "Patte d'Oie"];
                foreach ($villes1 as $key => $villes) {
                    $ville = new Ville();
                    $ville->setDepartement($dept1)
                        ->setNomVille($villes)
                        ->setStatut(true);
                    ;
                    $manager->persist($ville);

                }

                $villes2 = ["Golf Sud", "Médina Gounass", "Ndiarème Limamoulaye", "Sam Notaire", "Wakhinane Nimzatt"];
                foreach ($villes2 as $key => $villes) {
                    $ville = new Ville();
                    $ville->setDepartement($dept2)
                        ->setNomVille($villes)
                        ->setStatut(true);
                    ;
                    $manager->persist($ville);

                }

                $villes3 = ["Dalifort", "Djidah Thiaroye Kaw", "Guinaw Rail Nord", "Guinaw Rail Sud", "Pikine Est", "Pikine Nord", "Pikine Ouest", "Tivaouane Diacksao", "Diamaguène Sicap Mbao", "Mbao", "Thiaroye-sur-Mer", "Thiaroye Gare"];
                foreach ($villes3 as $key => $villes) {
                    $ville = new Ville();
                    $ville->setDepartement($dept3)
                        ->setNomVille($villes)
                        ->setStatut(true);
                    ;
                    $manager->persist($ville);

                }

                $villes4 = ["Rufisque Est", "Rufisque Nord", "Rufisque Ouest", "Bargny", "Sébikotane", "Diamniadio", "Sangalkam", "Sendou", "Yenne", "Bambylor"];
                foreach ($villes4 as $key => $villes) {
                    $ville = new Ville();
                    $ville->setDepartement($dept4)
                        ->setNomVille($villes)
                        ->setStatut(true);
                    ;
                    $manager->persist($ville);

                }

                $villes5 = ["Keur massar nord", "Keur massar Sud", "Malika", "Jaxaay-Parcelles-Niakoul Rab", "Tivaouane Peulh-Niaga",  "Yeumbeul Nord", "Yeumbeul Sud"];
                foreach ($villes5 as $key => $villes) {
                    $ville = new Ville();
                    $ville->setDepartement($dept5)
                        ->setNomVille($villes)
                        ->setStatut(true);
                    ;
                    $manager->persist($ville);

                }

            }

            if ($region == "Diourbel"){
                $dept1 = new Departement();
                $dept2 = new Departement();
                $dept3 = new Departement();

                $dept1->setRegion($rg)
                      ->setNomDept("Dioubel")
                      ->setStatut(true)
                ;
                $dept2->setRegion($rg)
                      ->setNomDept("Bambey")
                      ->setStatut(true)
                ;
                $dept3->setRegion($rg)
                      ->setNomDept("Mbacké")
                      ->setStatut(true)
                ;

                $manager->persist($dept1);
                $manager->persist($dept2);
                $manager->persist($dept3);
            
            }

            if ($region == "Fatick"){
                $dept1 = new Departement();
                $dept2 = new Departement();
                $dept3 = new Departement();
                
                $dept1->setRegion($rg)
                      ->setNomDept("Fatick")
                      ->setStatut(true)
                ;
                $dept2->setRegion($rg)
                      ->setNomDept("Foundiougne")
                      ->setStatut(true)
                ;
                $dept3->setRegion($rg)
                      ->setNomDept("Gosass")
                      ->setStatut(true)
                ;

                $manager->persist($dept1);
                $manager->persist($dept2);
                $manager->persist($dept3);
                
            }

            if ($region == "Kaffrine"){
                $dept1 = new Departement();
                $dept2 = new Departement();
                $dept3 = new Departement();
                $dept4 = new Departement();
                $dept1->setRegion($rg)
                      ->setNomDept("Kaffrine")
                      ->setStatut(true)
                ;
                $dept2->setRegion($rg)
                      ->setNomDept("Birkelane")
                      ->setStatut(true)
                ;
                $dept3->setRegion($rg)
                      ->setNomDept("Koungheul")
                      ->setStatut(true)
                ;
                $dept4->setRegion($rg)
                      ->setNomDept("Malem-Hodar")
                      ->setStatut(true)
                ;
                $manager->persist($dept1);
                $manager->persist($dept2);
                $manager->persist($dept3);
                $manager->persist($dept4);
            }

            if ($region == "Kaolack"){
                $dept1 = new Departement();
                $dept2 = new Departement();
                $dept3 = new Departement();
                
                $dept1->setRegion($rg)
                      ->setNomDept("Kaolack")
                      ->setStatut(true)
                ;
                $dept2->setRegion($rg)
                      ->setNomDept("Nioro du rip")
                      ->setStatut(true)
                ;
                $dept3->setRegion($rg)
                      ->setNomDept("Guinguinéo")
                      ->setStatut(true)
                ;
                $manager->persist($dept1);
                $manager->persist($dept2);
                $manager->persist($dept3);
                
            }

            if ($region == "Kédougou"){
                $dept1 = new Departement();
                $dept2 = new Departement();
                $dept3 = new Departement();
               
                $dept1->setRegion($rg)
                      ->setNomDept("Kédougou")
                      ->setStatut(true)
                ;
                $dept2->setRegion($rg)
                      ->setNomDept("Salemata")
                      ->setStatut(true)
                ;
                $dept3->setRegion($rg)
                      ->setNomDept("Saraya")
                      ->setStatut(true)
                ;
                $manager->persist($dept1);
                $manager->persist($dept2);
                $manager->persist($dept3);
                
            }

            if ($region == "Kolda"){
                $dept1 = new Departement();
                $dept2 = new Departement();
                $dept3 = new Departement();
               
                $dept1->setRegion($rg)
                      ->setNomDept("Kolda")
                      ->setStatut(true)
                ;
                $dept2->setRegion($rg)
                      ->setNomDept("Vélingara")
                      ->setStatut(true)
                ;
                $dept3->setRegion($rg)
                      ->setNomDept("Médina Yoro Foulah")
                      ->setStatut(true)
                ;
                $manager->persist($dept1);
                $manager->persist($dept2);
                $manager->persist($dept3);
            
            }

            if ($region == "Louga"){
                $dept1 = new Departement();
                $dept2 = new Departement();
                $dept3 = new Departement();
            
                $dept1->setRegion($rg)
                      ->setNomDept("Louga")
                      ->setStatut(true)
                ;
                $dept2->setRegion($rg)
                      ->setNomDept("Kébémer")
                      ->setStatut(true)
                ;
                $dept3->setRegion($rg)
                      ->setNomDept("Linguère")
                      ->setStatut(true)
                ;
                $manager->persist($dept1);
                $manager->persist($dept2);
                $manager->persist($dept3);
                
            }

            if ($region == "Matam"){
                $dept1 = new Departement();
                $dept2 = new Departement();
                $dept3 = new Departement();
                $dept4 = new Departement();
                $dept1->setRegion($rg)
                      ->setNomDept("Matam")
                      ->setStatut(true)
                ;
                $dept2->setRegion($rg)
                      ->setNomDept("Kanel")
                      ->setStatut(true)
                ;
                $dept3->setRegion($rg)
                      ->setNomDept("Ranérou")
                      ->setStatut(true)
                ;
                $dept4->setRegion($rg)
                      ->setNomDept("Rufisque")
                      ->setStatut(true)
                ;
                $manager->persist($dept1);
                $manager->persist($dept2);
                $manager->persist($dept3);
                $manager->persist($dept4);

            }

            if ($region == "Saint-Louis"){
                $dept1 = new Departement();
                $dept2 = new Departement();
                $dept3 = new Departement();
                
                $dept1->setRegion($rg)
                      ->setNomDept("Saint-Louis")
                      ->setStatut(true)
                ;
                $dept2->setRegion($rg)
                      ->setNomDept("Dagana")
                      ->setStatut(true)
                ;
                $dept3->setRegion($rg)
                      ->setNomDept("Podor")
                      ->setStatut(true)
                ;
                $manager->persist($dept1);
                $manager->persist($dept2);
                $manager->persist($dept3);
                
            }

            if ($region == "Sédhiou"){
                $dept1 = new Departement();
                $dept2 = new Departement();
                $dept3 = new Departement();
    
                $dept1->setRegion($rg)
                      ->setNomDept("Sédhiou")
                      ->setStatut(true)
                ;
                $dept2->setRegion($rg)
                      ->setNomDept("Goudomp")
                      ->setStatut(true)
                ;
                $dept3->setRegion($rg)
                      ->setNomDept("Bounkiling")
                      ->setStatut(true)
                ;
                $manager->persist($dept1);
                $manager->persist($dept2);
                $manager->persist($dept3);
            
            }

            if ($region == "Tambacounda"){
                $dept1 = new Departement();
                $dept2 = new Departement();
                $dept3 = new Departement();
                $dept4 = new Departement();
                $dept1->setRegion($rg)
                      ->setNomDept("Tambacounda")
                      ->setStatut(true)
                ;
                $dept2->setRegion($rg)
                      ->setNomDept("Bakel")
                      ->setStatut(true)
                ;
                $dept3->setRegion($rg)
                      ->setNomDept("Goudiry")
                      ->setStatut(true)
                ;
                $dept4->setRegion($rg)
                      ->setNomDept("Koumpentoum")
                      ->setStatut(true)
                ;
                $manager->persist($dept1);
                $manager->persist($dept2);
                $manager->persist($dept3);
                $manager->persist($dept4);
            }

            if ($region == "Thiès"){
                $dept1 = new Departement();
                $dept2 = new Departement();
                $dept3 = new Departement();
                $dept1->setRegion($rg)
                      ->setNomDept("Thiès")
                      ->setStatut(true)
                ;
                $dept2->setRegion($rg)
                      ->setNomDept("Mbour")
                      ->setStatut(true)
                ;
                $dept3->setRegion($rg)
                      ->setNomDept("Tivaoune")
                      ->setStatut(true)
                ;
                $manager->persist($dept1);
                $manager->persist($dept2);
                $manager->persist($dept3);
                
            }

            if ($region == "Ziguinchor"){
                $dept1 = new Departement();
                $dept2 = new Departement();
                $dept3 = new Departement();
                
                $dept1->setRegion($rg)
                      ->setNomDept("Ziguinchor")
                      ->setStatut(true)
                ;
                $dept2->setRegion($rg)
                      ->setNomDept("Oussouye")
                      ->setStatut(true)
                ;
                $dept3->setRegion($rg)
                      ->setNomDept("Bignona")
                      ->setStatut(true)
                ;

                $manager->persist($dept1);
                $manager->persist($dept2);
                $manager->persist($dept3);
                
            }

        }

        $manager->flush();
    }
}