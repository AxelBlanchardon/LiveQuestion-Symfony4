<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Entity\Question;
use App\Form\ReponseType;
use App\Form\QuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionController extends AbstractController
{
    /**
     * @Route("/question/{id}", name="voir_question")
     */
    public function voir_question(Question $question, Request $request, EntityManagerInterface $manager): Response
    {
        $reponse = new Reponse();
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
     
            $reponse->setAuteur($this->getUser())
                        ->setQuestion($question);
            
            $manager->persist($reponse);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre reponse a bien été pris en compte"
            );
        }
        return $this->render('question/index.html.twig', [
            'question' => $question,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/poser_une_question", name="poser_une_question")
     */
    public function poser_une_question(Request $request, EntityManagerInterface $manager): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
     
            $question->setAuteur($this->getUser());
            
            $manager->persist($question);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre question a bien été pris en compte"
            );
        }
        return $this->render('question/poser_question.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
