<?php

namespace App\Controller;

use App\Repository\CityRepository;
use App\Repository\StreetRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class AjaxController extends AbstractController
{
    /**
     * @Route("/customer/order-shipping-cities",name="client_shipping_cities"), methods="{POST}"
     */
    public function changeLivraionCity(Request $request, StreetRepository $streetRepository):Response
    {
        $id = $request->request->get('id_city');
        $street=$streetRepository->findbyCities($id);
        $reposne =[
            'code'=>200,
            'reponse'=>$this->render('client/order/ajax/index.html.twig',
                [
                    'items'=>$street,
                    'label'=>'',
                    'id'=>'payment1_street'
                ])->getContent()
        ];
        return new JsonResponse($reposne,200);
    }
    /**
     * @Route("/customer/order-shipping",name="client_shipping"), methods="{POST}"
     */
    public function changeLivraion(Request $request, CityRepository $cityRepository):Response
    {
        $id_pays = $request->request->get('id_pays');
        $pays=$cityRepository->findbyCountry($id_pays);
        $reposne =[
            'code'=>$id_pays,
            'reponse'=>$this->render('client/order/ajax/index.html.twig',
                [
                    'items'=>$pays,
                    'label'=>'Pays',
                    'id'=>'payment1_cities'
                ])->getContent()
        ];
        return new JsonResponse($reposne);
    }

}