<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @Route("/mon_profil")
 */
class CompteController extends AbstractController
{
     /**
     * @Route("/", name="mon_profil")
     */
    public function profil()
    {
        return $this->render('mon_profil.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/editer", name="editer_mon_profil")
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $utilisateur = $this->getUser();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            if (!empty($utilisateur->getPlainPassword())) {
                $utilisateur->setPassword(
                    $passwordEncoder->encodePassword(
                        $utilisateur,
                        $form->get('plainPassword')->getData()
                    )
                );

            }

            return $this->redirectToRoute('mon_profil');
        }

        return $this->render('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="utilisateur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Utilisateur $utilisateur): Response
    {
        $utilisateur = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            $this->get('security.token_storage')->setToken(null);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($utilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }

}
