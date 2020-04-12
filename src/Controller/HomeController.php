<?php

namespace App\Controller;


use App\Entity\Question;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('public/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
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

}
