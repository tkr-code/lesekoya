<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangeEmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class ResetEmailController extends AbstractController
{
    /**
     * @Route("/reset-email/{id}/{key}", name="reset_email")
     */
    public function index(Request $request, User $user, $key): Response
    {
        if(!$user){
            throw $this->createNotFoundException(
                'No user found for id '.$user
            );
        }
        $is_valide = true;
        if($user->getCle() == $key){
            $is_valide = false;
        }
        $form = $this->createForm(ChangeEmailType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            return $this->redirectToRoute('app_login');
        }
        return $this->renderForm('reset_email/index.html.twig', [
            'form' => $form,
            'is_valide'=>$is_valide
        ]);
    }
    /**
     * @Route("gestion-user/edit-email/{id}/{key}", name="edit_email")
     */
    public function editEmail(Request $request, User $user,  $key): Response
    {
        
        return $this->render('reset_email/edit-email.html.twig', [
        ]);
    }
}
