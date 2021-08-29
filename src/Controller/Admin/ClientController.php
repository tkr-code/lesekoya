<?php
namespace App\Controller\Admin;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrderRepository;


/**
 * @Route("/admin/client")
 */
class ClientController extends AbstractController
{
    private $repository;
    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * @Route("/{id}/order", name="admin_client_order")
     */
    public function clientOrder($id, OrderRepository $orderRepository): Response
    {
        return $this->render('admin/client/order/index.html.twig', [
            'nbrOrders'=>count($orderRepository->findAll()),
            'orders'=>$orderRepository->findStateClient($id),
            'ordersCompleted'=>$orderRepository->findStateClient($id ,'completed'),
            'ordersInProgress'=>$orderRepository->findStateClient($id, 'in progress'),
            'ordersWaiting'=>$orderRepository->findStateClient($id, 'waiting'),
            'ordersCanceled'=>$orderRepository->findStateClient($id, 'canceled'),
        ]);
    }
    /**
     * @Route("/", name="admin_client_index")
     */
    public function index():Response
    {
       return $this->render('admin/client/index.html.twig',[
           'clients'=>$this->repository->findAll()
       ]);
    }
}