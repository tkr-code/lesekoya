<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ArticleSearch;
use App\Entity\Client;
use App\Entity\Order;
use App\Entity\User;
use App\Form\ArticleSearchType;
use App\Repository\ClientRepository;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;

class MainController extends AbstractController
{
    /**
     * @Route("/nos-service", name="service")
     */
    public function service():Response
    {

        return $this->render('lest/service.html.twig');
    }
    /**
     * @Route("js/track-my-order/{number}", name="track_show")
     */
    public function trackOrder(Order $order):Response
    {
        if (!$order) {
            return new JsonResponse(['reponse'=>false]);
        }
        return new JsonResponse([
            'reponse'=>true,
            'content'=>$this->render('lest/track/_track_view.html.twig',[
                'order'=>$order
            ])->getContent() 
        ]);
    }
    /**
     * @Route("/track-my-order/", name="track_index")
     * @Route("/track-my-order/{number}", name="track_number")
     */
    public function track(Order $order  = null):Response
    {
        if($order){
            return $this->render('lest/track/index.html.twig',[
                'order'=>$order
            ]);
        }
        return $this->render('lest/track/index.html.twig');
    }
    /**
     * @Route("/help", name="help")
     */
    public function help():Response
    {
        return $this->render('lest/help.html.twig');
    }
    /**
     * @Route("/faq", name="faq")
     */
    public function faq():Response
    {
        return $this->render('lest/faq.html.twig');
    }
    /**
     * @Route("/change-lang/{locale}", name="lang")
     */
    public function changeLocale($locale, Request $request)
    {
    
        $locale = $request->attributes->get('locale');
        
        $request->getSession()->set('_locale', $locale);
        
        $request->setLocale($request->getSession()->get('_locale', $locale));    
        
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("gestion-user/delete/{id}/{key}", name="client_user_delete", methods={"GET"})
     */
    public function deleteUserGet(Request $request, Client $client, $key): Response
    {
        if (!$client) {
            throw $this->createNotFoundException(
                'No product found for id '.$client
            );
        }

        $is_valide = true;
        if($key  == $client->getUser()->getCle())
        {
            $reponse  = [
                'reponse'=>false,
            ];
            if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $user = $client->getUser();
                $user->setStatus('Delete');
                $newEmail ="delete-user-".$client->getId()."::".$client->getUser()->getEmail();
                $user->setEmail($newEmail);
                $client->setUser($user);
                $entityManager->flush();
                $reponse = [
                    'reponse'=>true,
                ];
                return $this->redirectToRoute('app_logout');
            }
            $is_valide = false;
        }

        return $this->render('delete/user/index.html.twig',[
            'user'=>$client,
            'is_valide'=>$is_valide,
        ]);
    }
    /**
     * @Route("gestion-user/js-delete/{id}/{key}", name="js_client_user_delete", methods={"POST"})
     */
    public function deleteUserPost(Request $request, Client $client, $key): Response
    {
        $reponse  = [
            'reponse'=>false,
        ];
        if($key  == $client->getUser()->getCle())
        {
            if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $user = $client->getUser();
                $user->setStatus('Delete');
                $newEmail ="delete-user-".$user->getId()."::".$client->getUser()->getEmail();
                $user->setEmail($newEmail);
                $client->setUser($user);
                $entityManager->flush();
                $reponse = [
                    'reponse'=>true,
                ];
                return new JsonResponse($reponse);
            }else{
                return new JsonResponse($reponse);
            }
        }
        return new JsonResponse($reponse);
    }
}