<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\ArticleSearch;
use App\Form\ArticleSearchType;

class Security1Controller extends AbstractController
{
    // /**
    //  * @Route("/login", name="app_login")
    //  */
    // public function login(AuthenticationUtils $authenticationUtils, UserRepository $userRepository): Response
    // {
    //     $search = new ArticleSearch();
    //     $formSearch = $this->createForm(ArticleSearchType::class,$search);
    //     if ($this->getUser()) {
    //         return $this->redirectToRoute('home');
    //     }

    //     // get the login error if there is one
    //     $error = $authenticationUtils->getLastAuthenticationError();
    //     // last username entered by the user
    //     $lastUsername = $authenticationUtils->getLastUsername();

    //     return $this->render('security/login2.html.twig', [
    //         'last_username' => $lastUsername, 
    //         'error' => $error,
    //         'users'=>$userRepository->findAll(),
    //         'form'=>$formSearch->createView()
    //     ]);
    // }

    // /**
    //  * @Route("/logout", name="app_logout")
    //  */
    // public function logout()
    // {
    //     throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    // }
}