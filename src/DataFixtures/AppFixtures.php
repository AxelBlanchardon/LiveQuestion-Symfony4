<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Avatar;
use App\Entity\Reponse;
use App\Entity\Question;
use App\Entity\Categorie;
use App\Entity\Utilisateur;
use App\Entity\QuestionLike;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
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

         // on créé 20 users
         for ($i = 0; $i < 20; $i++) {

            $utilisateur = new Utilisateur();
            $avatar = new Avatar();
            $url = 'https://randomuser.me/api/portraits/';
            $avatarId = $faker->numberBetween(1, 99) . '.jpg';
            $genre = $faker->randomElement($genres);
            $utilisateur->setGenre($genre);

            switch ($genre) {
                case "Homme":
                    $prenom = $faker->firstName('male');
                    $nom = $faker->lastName();
                    $url = $url . 'men/' . $avatarId;
                    break;
                case "Femme":
                    $prenom = $faker->firstName('female');
                    $nom = $faker->lastName();
                    $url = $url . 'women/' . $avatarId;
                    break;
                case "Autre":
                    $gender = $faker->randomElement($gendersUrl);
                    $prenom = $faker->firstName($faker->randomElement($genders));
                    $nom = $faker->lastName();
                    $url = $url . $gender . '/' . $avatarId;
                    break;
            }

            $nom=str_replace(' ','',$nom); //enleve les espaces possbibles dans le nom
            $pseudo = $prenom.$nom;
            $email = $pseudo.'@'.$faker->safeEmailDomain();

            $avatar->setUpdatedAt(new \DateTime())
                    ->setImageName($url);

            $utilisateur->setPseudo($pseudo)
                        ->setEmail($email)
                        ->setPassword($this->passwordEncoder->encodePassword($utilisateur, 'Userdemo1'))
                        ->setRoles(['ROLE_USER'])
                        ->setAvatar($avatar);

            $manager->persist($utilisateur);

            $users[] = $utilisateur; //tableau qui va contenir les utilisateurs créés par la fixture

        }

        //creation d'un admin
        $admin = new Utilisateur();
        $admin->setPseudo("Admin")
            ->setEmail("admin@gmail.com")
            ->setPassword($this->passwordEncoder->encodePassword($utilisateur, 'AdminPassword'))
            ->setGenre("Homme")
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);
        $manager->flush();

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
                        ->setCategorie($categorie)
                        ->setAuteur($auteur);

            $manager->persist($question);
            $questions[] = $question;

            for ($j=0; $j < mt_rand(0,10); $j++) {
                $like = new QuestionLike();
                $like->setQuestion($question)
                        ->setUtilisateur($faker->randomElement($users));
            $manager->persist($like);

            }
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
