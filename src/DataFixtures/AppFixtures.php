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
        $genders= ['male', 'female'];
        $gendersUrl = ['men', 'women'];

        $users = array();

         // on créé 40 users
         for ($i = 0; $i < 40; $i++) {

            $utilisateur = new Utilisateur();

            $prenom = $faker->firstName($genders);
            $nom = $faker->lastName($genders);
            $nom=$nom; $nom=str_replace(' ','',$nom); //enleve les espaces possbibles dans le nom
            $pseudo = $prenom.$nom;
            $email = $pseudo.'@'.$faker->safeEmailDomain();
            $utilisateur->setGenre($faker->randomElement($genres));
            $avatar = 'https://randomuser.me/api/portraits/';
            $avatarId = $faker->numberBetween(1, 99) . '.jpg';
            $genre = $utilisateur->getGenre();

            switch ($genre) {
                case "Homme":
                    $avatar = $avatar . 'men/' . $avatarId;
                    break;
                case "Femme":
                    $avatar = $avatar . 'women/' . $avatarId;
                    break;
                case "Autre":
                    $gender = $faker->randomElement($gendersUrl);
                    $avatar = $avatar . $gender . '/' . $avatarId;
                    break;
            }

            $utilisateur->setPseudo($pseudo)
                        ->setEmail($email)
                        ->setPassword($this->passwordEncoder->encodePassword($utilisateur, 'Userdemo1'))
                        ->setRoles(['ROLE_USER'])
                        ->setAvatar($avatar);

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

        //Creation de 30 questions
        $questions = array();

        for ($i=0; $i < 30; $i++) { 
            
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

         //Creation de 40 reponses
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
