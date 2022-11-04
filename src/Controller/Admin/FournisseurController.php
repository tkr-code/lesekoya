<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\ClientType;
use App\Service\Service;
use App\Form\FournisseurType;
use App\Form\UserPasswordType;
use App\Form\FournisseurEditType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/my-account/fournisseurs")
 */
class FournisseurController extends AbstractController
{
    private $parent_page = 'Fournisseur';
    /**
     * @Route("/", name="admin_fournisseur_index")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/fournisseur/index.html.twig',[
            'fournisseurs'=>$userRepository->findByRole('ROLE_FOURNISSEUR'),
            'parent_page'=>$this->parent_page
        ]);
    }
    /**
     * @Route("/new", name="admin_fournisseur_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface, Service $service): Response
    {
        $user = new User();
        $user->setIsActive('Activer')
        ->setRoles([User::ROLE_FOURNISSEUR])
        ->setCle($service->aleatoire(100));
        $form = $this->createForm(FournisseurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adresse = $user->getAdresse();
            if($adresse){
                $adresse->setFirstName($user->getFirstName())
                ->setLastName($user->getLastName())
                ->setTel($form->get('phone_number')->getData())
                ;
                $user->setAdresse($adresse);
            }
            $user->setPassword(
                $userPasswordHasherInterface->hashPassword(
                    $user,
                    $user->getPassword()
                )
            );
            $user->setIsActive(true);

            $em=  $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success','Un nouveau client a été ajouté.');
            return $this->redirectToRoute('admin_fournisseur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/fournisseur/new.html.twig', [
            'form' => $form,
            'parent_page'=>$this->parent_page
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_fournisseur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $client, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {

        $form = $this->createForm(FournisseurEditType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Le fournisseur a été modifié.');
            return $this->redirectToRoute('admin_fournisseur_index', [], Response::HTTP_SEE_OTHER);
        }

        $formPassword = $this->createForm(UserPasswordType::class,$client);
        $formPassword->handleRequest($request);

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {
            $client->setPassword($userPasswordHasherInterface->hashPassword($client, $formPassword->get('password')->getData()));
            $this->getDoctrine()->getManager()->flush($client);
            $this->addFlash('success','Le mot de passe du client a été modifié');
            return $this->redirectToRoute('admin_fournisseur_index',[],Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/fournisseur/edit.html.twig', [
            'form' => $form,
            'form_password'=>$formPassword,
            'parent_page'=>$this->parent_page
        ]);
    }
}
