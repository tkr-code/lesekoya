<?php

namespace App\Controller\Email;

use App\Entity\Order;
use App\Form\ChangePasswordFormType;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Service\Email\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    private $emailService;
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }
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
     * @Route("/email/contact", name="email_contact")
     */
    public function contact(): Response
    {
        return $this->render('email/contact.html.twig', [
            'theme'=>$this->emailService->theme(6),
            'name'=>'Malick tounkara',
            'phone'=>'781278288',
            'mail'=>'malick@gmail.com',
            'message'=>'Vous faites des logicies ?'
        ]);
    }
    /**
     * @Route("/email/order", name="email_order")
     */
    public function order(OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->find(6);
        return $this->render('email/order.html.twig',[
            'theme'=>$this->emailService->theme(4),
            'order'=>$order 
        ]);
    }
    /**
     * @Route("/email/new-user", name="email_new_user")
     */
    public function newUser(UserRepository $userRepository): Response
    {
        $user = $userRepository->find(103);
        return $this->render('email/new-user.html.twig',[
            'theme'=>$this->emailService->theme(5),
            'user'=>$user,
            'password'=>'password' 
        ]);
    }
    /**
     * @Route("/email/confirmation", name="email_register")
     */
    public function confirmation(EmailService $emailService): Response
    {
        return $this->render('email/confirmation.html.twig',
        [
            'theme'=>$emailService->theme(1)
            ]
        );
    }
    /**
     * @Route("/email/reset-password", name="email_reset_password")
     */
    public function reserPassword(EmailService $emailService): Response
    {
        return $this->render('email/reset-password.html.twig',[
            'theme'=>$emailService->theme(2)
        ]);
    }
}
