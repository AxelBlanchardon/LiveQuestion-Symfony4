<?php

namespace App\Controller;


use App\Entity\Question;
use App\Entity\QuestionLike;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\QuestionLikeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('public/index.html.twig');
    }

    /**
     * @Route("/accueil", name="accueil")
     */
    public function accueil(QuestionRepository $QuestionRepository): Response
    {

        return $this->render('public/accueil.html.twig', [
            'questions' => $QuestionRepository->findBy(array(),array('createdAt' => 'DESC')),
        ]);
    }

    /**
     * @Route("/question/{id}/like", name="question_like")
     */
    public function like(Question $question, QuestionRepository $QuestionRepository, EntityManagerInterface $manager, QuestionLikeRepository $likeRepository): Response
    {
        $utilisateur = $this->getuser();

        if ($question->isLikedByUser($utilisateur)) {
            $like = $likeRepository->findOneBy([
                'question' => $question,
                'utilisateur' => $utilisateur
            ]);

            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like bien supprime',
                'likes' => $likeRepository->count(['question' => $question])
            ], 200);
        }

        $like = new QuestionLike();
        $like->setQuestion($question)
            ->setUtilisateur($utilisateur);

        $manager->persist($like);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Like bien ajoute',
            'likes' => $likeRepository->count(['question' => $question])
        ], 200);


        return $this->json(['code' => 200, 'message' => 'Action sans erreur'], 200);
    }


}
