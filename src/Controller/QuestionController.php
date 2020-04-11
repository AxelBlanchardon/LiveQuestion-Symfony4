<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Entity\Question;
use App\Form\ReponseType;
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
}
