<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class GoogleController extends AbstractController
{
    /**
     * @Route("/oauth/check/google", name="connect_google")
     */
    public function connectAction(ClientRegistry $clientRegistry): RedirectResponse
    {
        $client = $clientRegistry->getClient('google');
        // return $client->redirect(["openid","https://www.googleapis.com/auth/userinfo.email", 
        //     "https://www.googleapis.com/auth/userinfo.profile"]);
        return $client->redirect(['profile']);
    }
    /**
     * @Route("/connect/google/check", name="connect_google_check")
     */
    public function connectCheckAction(Request $request): RedirectResponse
    {
       if(!$this->getUser()){
        return new JsonResponse(['status'=>false,'message'=>'User not founf']);
       } else{
        return $this->redirectToRoute('admin');
       }
    }
}
