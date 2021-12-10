<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\User;
use App\Form\ProfileType;
use App\Repository\UserRepository;
use App\Form\ChangePasswordFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("admin/profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/", name="profile_index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $user =  $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        return $this->renderForm('admin/profile/index.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/new", name="profile_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profile/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="profile_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('profile/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("-edit", name="profile_edit", methods={"GET","POST"})
     */
    public function edit(Request $request): Response
    {
        $user = $this->getUser();
        $resetForm = $this->createForm(ChangePasswordFormType::class);
        
        $form = $this->createForm(ProfileType::class, $user,[]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('avatar')->getData();
            // dump($image);
            $personne = $user->getPersonne();
            if ($image) {
                # code...
                $fichier = md5(uniqid()). '.'.$image->guessExtension();
                $image->move(
                $this->getParameter('user_images_directory'),
                $fichier
                );
                $personne->setAvatar($fichier);
            }
            $user->setPersonne($personne);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','profil modify');
            return $this->redirectToRoute('profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/profile/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'resetForm'=>$resetForm
        ]);
    }
    /**
     * @Route("-edit-password", name="profile_edit_password", methods={"GET","POST"})
     */
    public function editPassword(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordFormType::class);        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personne = $user->getPersonne();
            $user->setPersonne($personne);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Profil modify');
            return $this->redirectToRoute('profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/profile/edit-email.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="profile_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profile_index', [], Response::HTTP_SEE_OTHER);
    }
}