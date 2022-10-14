<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\User1Type;
use App\Entity\Personne;
use App\Service\Service;
use App\Form\GerantEditType;
use App\Form\GerantNewType;
use App\Form\UserPasswordType;
use App\Repository\UserRepository;
use App\Service\Email\EmailService;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class GerantController extends AbstractController
{
   private $userRepository;
   private $parent_page = 'Gérant';
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * @Route("/admin/gerant", name="gerant_index")
     */
    public function index(): Response
    {
        return $this->render('admin/gerant/index.html.twig',[
            'gerants'=>$this->userRepository->findByRole('ROLE_EDITOR'),
            'parent_page'=>$this->parent_page
        ]);
    }
        /**
     * @Route("admin/gerant/new", name="gerant_new", methods={"GET","POST"})
     */
    public function new(Service $service, Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        $personne = new Personne();
        $user->setPersonne($personne);
        $user->setRoles(['ROLE_EDITOR']);
        $form = $this->createForm(GerantNewType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($userPasswordHasherInterface->hashPassword($user,$user->getPassword()));
            $user->setCle($service->aleatoire(100));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success','Le compte gérant a été créé');
            return $this->redirectToRoute('gerant_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/gerant/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'parent_page'=>$this->parent_page
        ]);
    }

        /**
     * @Route("admin/gerant/{id}/edit", name="gerant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $form = $this->createForm(GerantEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Les modifications ont été enregistré');
            return $this->redirectToRoute('gerant_index', [], Response::HTTP_SEE_OTHER);
        }
        
        $formPassword = $this->createForm(UserPasswordType::class,$user);
        $formPassword->handleRequest($request);
        if ($formPassword->isSubmitted() && $formPassword->isValid()) {
            $user->setPassword($userPasswordHasherInterface->hashPassword($user, $formPassword->get('password')->getData()));
            $this->addFlash('success','Le mot de passe a été enregistré');
            $this->getDoctrine()->getManager()->flush($user);
            return $this->redirectToRoute('gerant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gerant/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'formPassword' => $formPassword,
            'parent_page'=>$this->parent_page
        ]);
    }


}
