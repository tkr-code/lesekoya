<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\User;
use App\Form\User1Type;
use App\Repository\UserRepository;
use App\Service\Email\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

/**
 * @Route("admin/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(MailerInterface $mailerInterface, EmailService $emailService, Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        $personne = new Personne();
        $personne->setFirstName('Malick')->setLastName('Tounkara');
        $user->setPersonne($personne);
        $user->setEmail('email@leseokya.com')
        ->setAdresse('sacre coeur 3')
        ->setPassword('password')
        ->setPhoneNumber('772495592')
        ->isVerified(true);
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($userPasswordHasherInterface->hashPassword($user,$user->getPassword()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            if($form->get('sendEmail')->getData()){
               $email = (new TemplatedEmail())
                 ->from(new Address('contact@lesekoya.com', 'Création de compte'))
                    ->to($user->getEmail())
                    ->subject('Confirmation de compte')
                    ->htmlTemplate('email/new-user.html.twig')
                    ->context([
                        'theme'=>$emailService->theme(5),
                        'user'=>$user,
                        'password'=>$form->get('password')->getData()
                    ]);
                    $mailerInterface->send($email);
            }
            $this->addFlash('success','Le compte à été créé');
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($userPasswordHasherInterface->hashPassword($user, $user->getPassword()));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}