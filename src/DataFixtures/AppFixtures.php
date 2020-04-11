<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Utilisateur;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
         // On configure dans quelles langues nous voulons nos données
         $faker = Faker\Factory::create('fr_FR');

         $genres = ['Homme', 'Femme', 'Autre'];
         $users = array();

         // on créé 20 users
         for ($i = 0; $i < 20; $i++) {

             $utilisateur = new Utilisateur();

             $utilisateur->setGenre($faker->randomElement($genres));
             $utilisateur->setPseudo($faker->Username());
             $utilisateur->setEmail($faker->email());
             $utilisateur->setPassword($this->passwordEncoder->encodePassword(
                 $utilisateur,
                 'Userdemo1'
             ));
             $utilisateur->setRoles(['ROLE_USER']);

             $manager->persist($utilisateur);

             $users[] = $utilisateur; //tableau qui va contenir les utilisateurs créés par la fixture

        }
        
        //Creation des categories
        $categs = [];
        
         $categs[1] = new Categorie();
         $categs[1]->setNom("art");
         $categs[2] = new Categorie();
         $categs[2]->setNom("jeux-videos");
         $categs[3] = new Categorie();
         $categs[3]->setNom("serie");
         $categs[4] = new Categorie();
         $categs[4]->setNom("cinema");
         $categs[5] = new Categorie();
         $categs[5]->setNom("sport");

        for ($i=1; $i < 6; $i++) { 
            $manager->persist($categs[$i]);
        }

         //Creation de questions

         $questions = array();

         for ($i=0; $i < 10; $i++) { 
            
            $titre = $faker->sentence();
            $createdAt = $faker->datetimeBetween('-100 days', '-1 days');
            $auteur = $users[mt_rand(0, count($users) - 1)];
            $categorie = $categs[mt_rand(1, count($categs) - 1)];
            $question = new Question();

            $question->setTitre($titre)
                        ->setCreatedAt($createdAt)
                        ->addCategorie($categorie)
                        ->setAuteur($auteur);
            
            $manager->persist($question);

            $questions[] = $question;
         }

         //Creation de reponses

         for ($i=0; $i < 40; $i++) { 

            $reponse = new Reponse();
            $contenu = $faker->sentence();
            $createdAt = $faker->datetimeBetween('-100 days', '-1 days');
            $auteur = $users[mt_rand(0, count($users) - 1)];
            $laQuestion = $questions[mt_rand(0, count($questions) - 1)];
            $categorie = $categs[mt_rand(1, count($categs) - 1)];


            $reponse->setContenu($contenu)
                        ->setDate($createdAt)
                        ->setAuteur($auteur)
                        ->setQuestion($laQuestion);
            
            $manager->persist($reponse);
         }

        $manager->flush();
    }
}
