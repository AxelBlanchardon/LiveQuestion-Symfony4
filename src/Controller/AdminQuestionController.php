<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminQuestionController extends AbstractController
{
    /**
     * @Route("/admin/questions", name="admin_question_index")
     */
    public function index(QuestionRepository $QuestionRepository)
    {
        return $this->render('admin/question/index.html.twig', [
            'questions' => $QuestionRepository->findAll()
        ]);
    }

    /**
     * Permet de supprimer une annonce
     *
     * @Route("/admin/questions/{id}/delete", name="admin_question_delete")
     *
     * @param Ad $ad
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Question $question, EntityManagerInterface $manager) {

        $manager->remove($question);
        $manager->flush();

        $this->addFlash(
            'success',
            "La question {$question->getTitre()} a bien été supprimée !"
        );

        return $this->redirectToRoute('admin_question_index');
    }

}
