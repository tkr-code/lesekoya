<?php

namespace App\Controller\Email;

use App\Entity\Order;
use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Repository\ClientRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Service\Email\EmailService;
use App\Service\Order\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmailTestController extends AbstractController
{
    private $emailService;
    private $client;
    private $user;
    public function __construct(EmailService $emailService, UserRepository $userRepository)
    {

        $user = $userRepository->findOneBy([
            'email'=>'test@email.com'
        ]);
        if($user){
            $this->user = $user;
            $this->client = $user->getClient();
        }
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
     * @Route("/email/order/{id}", name="email_order")
     */
    public function order(OrderRepository $orderRepository, OrderService $orderService, Order $order): Response
    {
        return $this->render('email/order.html.twig',[
            'theme'=>$this->emailService->theme(4),
            'order'=>$order,
            'etat'=>$orderService->stateTranslate($order),
            'user'=>$this->user 
        ]);
    }
    /**
     * @Route("/email/notification/{id}", name="email_order_notification")
     */
    public function orderNotification(OrderRepository $orderRepository, OrderService $orderService, Order $order): Response
    {
        return $this->render('email/order_notiification.html.twig',[
            'theme'=>$this->emailService->theme(8),
            'order'=>$order 
        ]);
    }
    /**
     * @Route("/email/facture/{id}", name="email_facture")
     */
    public function facture(OrderService $orderService, OrderRepository $orderRepository, Order $order): Response
    {
        return $this->render('email/facture.html.twig',[
            'theme'=>$this->emailService->theme(4),
            'order'=>$order,
            'etat'=>$orderService->stateTranslate($order),
            'user'=>$this->user 
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
     * @Route("/email/edit-email/{id}", name="email_edit_email")
     */
    public function editEmail(User $user): Response
    {
        return $this->render('email/reset-email.html.twig',[
            'theme'=>$this->emailService->theme(3),
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
            'user'=>$this->user,
            'theme'=>$emailService->theme(1)
            ]
        );
    }

    /**
     * @Route("/email/confirmation-none", name="email_register_none")
     */
    public function confirmationOut(EmailService $emailService): Response
    {
        return $this->render('email/confirmation.html.twig',
        [
            'theme'=>$emailService->theme('5.1')
            ]
        );
    }
    /**
     * @Route("/email/reset-password", name="email_reset_password")
     */
    public function reserPassword(EmailService $emailService): Response
    {
        return $this->render('email/reset-password.html.twig',[
            'theme'=>$emailService->theme(2),
            'user'=>$this->user,
        ]);
    }
}
