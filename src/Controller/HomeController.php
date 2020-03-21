<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/mon_profil", name="mon_profil")
     */
    public function profil()
    {
        return $this->render('monProfil.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
