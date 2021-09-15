<?php

namespace App\Controller;

use App\Repository\CityRepository;
use App\Repository\ShippingAmountRepository;
use App\Repository\StreetRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class AjaxController extends AbstractController
{
    /**
     * @Route("/order-shipping-cities", name="client_shipping_cities", methods={"GET","POST"} )
     */
    public function changeLivraionCity(Request $request, StreetRepository $streetRepository):Response
    {
        $id = $request->request->get('id_city');
        $street=$streetRepository->findbyCities($id);
        $reposne =[
            'code'=>200,
            'reponse'=>$this->render('client/order/ajax/select.html.twig',
                [
                    'items'=>$street,
                    'label'=>'',
                    'name'=>'name',
                    'id'=>'payment1_street'
                ])->getContent()
        ];
        return new JsonResponse($reposne,200);
    }
    /**
     * @Route("/order-shipping", name="client_shipping", methods={"GET","POST"})
     */
    public function changeLivraion(Request $request, StreetRepository $streetRepository):Response
    {
        $id_city = $request->request->get('id_city');
        $cities=$streetRepository->findbyCities($id_city);
        $response =[
            'response'=>$this->render('client/order/ajax/select.html.twig',
                [
                    'items'=>$cities,
                    'label'=>'Pays',
                    'name'=>'street',
                    'id'=>'streets'
                ])->getContent()
        ];
        return new JsonResponse($response,200);
    }
    /**
     * @Route("/order-shipping-amount", name="client_shipping_amount", methods={"GET","POST"})
     */
    public function changeAmount(ShippingAmountRepository $shippingAmountRepository ,Request $request):Response
    {
        $id_street = $request->request->get('id_street');
        $amount = $shippingAmountRepository->findByStreet($id_street);
        $response =[
            'amount'=>$amount,
            'response'=>$this->render('client/order/ajax/amount.html.twig',
                [
                    'amount'=>$amount
                ])->getContent()
        ];
        return new JsonResponse($response,200);
    }

}