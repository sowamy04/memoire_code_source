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
        "K??dougou", "Kolda", "Louga", "Matam", "Saint-Louis", "S??dhiou", 
        "Tambacounda", "Thi??s", "Ziguinchor" ];
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
                      ->setNomDept("Gu??diwaye")
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

                $villes1 = ["Mermoz-Sacr??-C??ur", "Ngor", "Ouakam", "Yoff", "Dakar-Plateau", "Fann-Point E-Amiti??", "Gueule Tap??e-Fass-Colobane", "M??dina","Biscuiterie", "Dieuppeul-Derkl??", "Grand Dakar", "Hann Bel-Air", "HLM", "Sicap-Libert??","Camb??r??ne", "Grand Yoff", "Parcelles Assainies", "Patte d'Oie"];
                foreach ($villes1 as $key => $villes) {
                    $ville = new Ville();
                    $ville->setDepartement($dept1)
                        ->setNomVille($villes)
                        ->setStatut(true);
                    ;
                    $manager->persist($ville);

                }

                $villes2 = ["Golf Sud", "M??dina Gounass", "Ndiar??me Limamoulaye", "Sam Notaire", "Wakhinane Nimzatt"];
                foreach ($villes2 as $key => $villes) {
                    $ville = new Ville();
                    $ville->setDepartement($dept2)
                        ->setNomVille($villes)
                        ->setStatut(true);
                    ;
                    $manager->persist($ville);

                }

                $villes3 = ["Dalifort", "Djidah Thiaroye Kaw", "Guinaw Rail Nord", "Guinaw Rail Sud", "Pikine Est", "Pikine Nord", "Pikine Ouest", "Tivaouane Diacksao", "Diamagu??ne Sicap Mbao", "Mbao", "Thiaroye-sur-Mer", "Thiaroye Gare"];
                foreach ($villes3 as $key => $villes) {
                    $ville = new Ville();
                    $ville->setDepartement($dept3)
                        ->setNomVille($villes)
                        ->setStatut(true);
                    ;
                    $manager->persist($ville);

                }

                $villes4 = ["Rufisque Est", "Rufisque Nord", "Rufisque Ouest", "Bargny", "S??bikotane", "Diamniadio", "Sangalkam", "Sendou", "Yenne", "Bambylor"];
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
                      ->setNomDept("Mback??")
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
                      ->setNomDept("Guinguin??o")
                      ->setStatut(true)
                ;
                $manager->persist($dept1);
                $manager->persist($dept2);
                $manager->persist($dept3);
                
            }

            if ($region == "K??dougou"){
                $dept1 = new Departement();
                $dept2 = new Departement();
                $dept3 = new Departement();
               
                $dept1->setRegion($rg)
                      ->setNomDept("K??dougou")
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
                      ->setNomDept("V??lingara")
                      ->setStatut(true)
                ;
                $dept3->setRegion($rg)
                      ->setNomDept("M??dina Yoro Foulah")
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
                      ->setNomDept("K??b??mer")
                      ->setStatut(true)
                ;
                $dept3->setRegion($rg)
                      ->setNomDept("Lingu??re")
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
                      ->setNomDept("Ran??rou")
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

            if ($region == "S??dhiou"){
                $dept1 = new Departement();
                $dept2 = new Departement();
                $dept3 = new Departement();
    
                $dept1->setRegion($rg)
                      ->setNomDept("S??dhiou")
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

            if ($region == "Thi??s"){
                $dept1 = new Departement();
                $dept2 = new Departement();
                $dept3 = new Departement();
                $dept1->setRegion($rg)
                      ->setNomDept("Thi??s")
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