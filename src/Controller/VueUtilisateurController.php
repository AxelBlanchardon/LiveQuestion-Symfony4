<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Utilisateur;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VueUtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur/{pseudo}", name="vue_utilisateur")
     */
    public function vueUtilisateur(string $pseudo, Utilisateur $utilisateur)
    {
        $utilisateur = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneByPseudo($pseudo);
        $questions = $this->getDoctrine()->getRepository(Question::class)->findBy(array('auteur' => $utilisateur->getId()), array('createdAt' => 'ASC'));
        if (!$utilisateur) {
            return $this->createNotFoundException();
        }
        return $this->render('vue_utilisateur/index.html.twig', [
            'utilisateur' => $utilisateur,
            'questions' => $questions,
        ]);
    }
}
