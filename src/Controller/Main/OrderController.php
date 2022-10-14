<?php

namespace App\Controller\Main;

use App\Entity\Order;

use App\Service\Email\EmailService;
use App\Service\Pdf\PdfService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/main")
 */
class OrderController extends AbstractController
{
    private $emailService;
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Telecharger une commande
     * @Route("/order-download/{id}", name="order_download", methods={"POST","GET"})
     */
    public function orderDowload(Order $order, PdfService $pdfService):Response{
        $pdfService->orderToPdf($order,true);
        return new Response();
    }

    /**
     * AFFICHER UNE COMMANDE
     * @Route("/order/{id}", name="main_order_show", methods={"GET","POST"})
     */
    public function show(Order $order, Request $request): Response
    {
        $reponse = [
            'reponse' => false
        ];
        if($request->get('ajax')){
            $reponse = [
                'content' => $this->render('admin/order/_order.html.twig', ['order' => $order])->getContent(),
                'reponse' => true,
            ];
        }
        return new JsonResponse($reponse);
    }

    /**
     * ANNULLER UNE COMANDE
     * @Route("/edit-order-state/{id}", name="main_edit_order_state", methods={"POST","GET"})
     */
    public function editOrderState(Order $order, Request $request): Response
    {
        $reponse = [
            'reponse'=>false
        ];
        
        if ($request->request->get('ajax')) {
            $order->setState('canceled');
            $this->getDoctrine()->getManager()->flush($order);

            $reponse = [
                'reponse'=>true,
                'content'=>$this->render('lest/order/_order.html.twig')->getContent()
            ];
            return new JsonResponse($reponse);
        }

        return new JsonResponse($reponse);
    }
}