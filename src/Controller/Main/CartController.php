<?php

namespace App\Controller\Main;

use App\Repository\ArticleRepository;
use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ArticleSearch;
use App\Form\ArticleSearchType;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(CartService $cartService, Request $request): Response
    {
        $search = new ArticleSearch();
        $form = $this->createForm(ArticleSearchType::class,$search);
        if ($request->request->count() > 0) {
            $cartService->addPost($request->request->get('article_id'),$request->request->get('qty'));
            $this->addFlash('success','panier modiifer');
            return $this->redirectToRoute('cart_index');
        }
        return $this->render('main/cart/index.html.twig',[
            'items'=>$cartService->getFullCart(),
            'total'=>$cartService->getTotal(),
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("cart/add/{id}", name="cart_add")
     */
    public function add(int $id, CartService $cartService )
    {
        $cartService->add($id);
        return $this->redirectToRoute('cart_index');
    }
    /**
     * @Route("/cart/remove/{id}", name="cart_remove", methods="GET")
     */
    public function remove($id, CartService $cartService)
    {
        $cartService->remove($id);
        // $this->addFlash('success','Le produit retiré du panier');
        return $this->redirectToRoute('cart_index');
    }
    /**
     * @Route("/cart/delete/{id}", name="cart_delete", methods="GET")
     */
    public function delete($id, CartService $cartService)
    {
        $cartService->delete($id);
        // $this->addFlash('success','Le produit retiré du panier');
        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/cart/clear", name="cart_clear", methods="GET")
     */
    public function claer(CartService $cartService)
    {
        $cartService->clear();
        return $this->redirectToRoute('cart_index');
    }
}