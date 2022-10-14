<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\ArticleSearch;
use App\Entity\User;
use App\Form\ArticleSearchType;
use App\Form\RegistrationFormType;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, UserRepository $userRepository): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }
        // $search = new ArticleSearch();
        // $formSearch = $this->createForm(ArticleSearchType::class,$search);

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // FORM DE CREATION DE COMPTE
        $user = new User();
        $registrationForm = $this->createForm(RegistrationFormType::class,$user);

        return $this->renderForm('security/index.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error,
            'users'=>$userRepository->findAll(),
            // 'form'=>$formSearch,
            'registrationForm'=>$registrationForm
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}