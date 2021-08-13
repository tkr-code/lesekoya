<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Service\Card\CardService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card_index")
     */
    public function index(CardService $cardService): Response
    {
        return $this->render('main/card/index.html.twig',[
            'items'=>$cardService->getFullCard(),
            'total'=>$cardService->getTotal()
        ]);
    }

    /**
     * @Route("card/add/{id}", name="card_add")
     */
    public function add(int $id, CardService $cardService )
    {
        $cardService->add($id);
        return $this->redirectToRoute('card_index');
    }
    /**
     * @Route("/card/remove/{id}", name="card_remove", methods="GET")
     */
    public function remove($id, CardService $cardService)
    {
        $cardService->remove($id);
        // $this->addFlash('success','Le produit retiré du panier');
        return $this->redirectToRoute('card_index');
    }
    /**
     * @Route("/card/delete/{id}", name="card_delete", methods="GET")
     */
    public function delete($id, CardService $cardService)
    {
        $cardService->delete($id);
        // $this->addFlash('success','Le produit retiré du panier');
        return $this->redirectToRoute('card_index');
    }
}