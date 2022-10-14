<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\User;
use App\Form\User1EditType;
use App\Form\User1Type;
use App\Form\UserPasswordType;
use App\Repository\UserRepository;
use App\Service\Email\EmailService;
use App\Service\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class UserController extends AbstractController
{
    private $parent_page = 'User';
    /**
     * @Route("admin/user/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->findAllUsers(),
            'parent_page'=>$this->parent_page
        ]);
    }

    /**
     * @Route("admin/user/new", name="user_new", methods={"GET","POST"})
     */
    public function new(MailerInterface $mailerInterface, Service $service, EmailService $emailService, Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        $personne = new Personne();
        // $personne->setFirstName('Malick')->setLastName('Tounkara');
        // $user->setPersonne($personne);
        // $user->setEmail('email@lest.com')
        // ->setPassword('password')
        // ->setPhoneNumber('772495592');
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($userPasswordHasherInterface->hashPassword($user,$user->getPassword()));
            $user->setCle($service->aleatoire(100));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            if($form->get('sendEmail')->getData()){
               $email = (new TemplatedEmail())
                 ->from(new Address('contact@lest.com', 'Création de compte'))
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
            'parent_page'=>$this->parent_page
        ]);
    }

    /**
     * @Route("admin/user/{id}/client", name="user_show_client", methods={"GET"})
     * @Route("admin/user/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
            'parent_page'=>$this->parent_page
        ]);
    }

    /**
     * @Route("admin/user/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $form = $this->createForm(User1EditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $user->setPassword($userPasswordHasherInterface->hashPassword($user, $user->getPassword()));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }
        
        $formPassword = $this->createForm(UserPasswordType::class,$user);
        $formPassword->handleRequest($request);
        if ($formPassword->isSubmitted() && $formPassword->isValid()) {
            $user->setPassword($userPasswordHasherInterface->hashPassword($user, $formPassword->get('password')->getData()));
            $this->addFlash('success','Le mot de passe a été enregistré');
            $this->getDoctrine()->getManager()->flush($user);
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'formPassword' => $formPassword,
            'parent_page'=>$this->parent_page
        ]);
    }

    /**
     * @Route("admin/user/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
           $email = $user->getEmail();
            // $entityManager->remove($user);
            // $entityManager->flush();
            dd($user);
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}