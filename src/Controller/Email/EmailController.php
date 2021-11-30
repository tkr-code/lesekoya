<?php

namespace App\Controller\Email;

use App\Service\Email\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    /**
     * @Route("/email", name="email_index")
     */
    public function index(): Response
    {
        return $this->render('email/index.html.twig', [
            'controller_name' => 'EmailController',
        ]);
    }
    /**
     * @Route("/email/confirmation", name="email_register")
     */
    public function confirmation(EmailService $emailService): Response
    {
        return $this->render('email/confirmation.html.twig',$emailService->theme(1));
    }
    /**
     * @Route("/email/reset-password", name="email_reset_password")
     */
    public function reserPassword(EmailService $emailService): Response
    {
        return $this->render('email/reset-password.html.twig',$emailService->theme(2));
    }
}
