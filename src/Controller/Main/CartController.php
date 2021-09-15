<?php

namespace App\Controller\Main;

use App\Entity\Payment;
use App\Form\Payment1Type;
use App\Entity\ArticleSearch;
use App\Entity\DeliverySpace;
use App\Form\ArticleSearchType;
use App\Form\DeliverySpaceType;
use App\Service\Cart\CartService;
use App\Repository\CityRepository;
use App\Repository\StreetRepository;
use App\Repository\ArticleRepository;
use App\Repository\ShippingAmountRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    /**
     * cart
     * @Route("/cart/order-step-1", name="cart_step_1")
     * @return void
     */
    public function step1(ShippingAmountRepository $shippingAmountRepository, Request $request):Response
    {
        // recupere la rue
        $id_street = $request->request->get('street');
        // on recuppere le montant corespondant
        $amount = $shippingAmountRepository->findByStreet($id_street);
        //on recupere la methode de paiment
        $methodPaiement = $request->request->get('method');
        // on recupere le total du panier
        $total = $this->cartService->getTotal();
        //on gener la nouvelle commande avec le prix de la livraion
        dump($request->request);
        return $this->render('lesekoya/cart/order-step-1.html.twig',[
            'items'=>$this->cartService->getFullCart(),
            'subtotal'=>$this->cartService->getTotal(),
            'shippingAmount'=>$amount,
            'methodPayment'=>$methodPaiement

        ]);
    }
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(StreetRepository $streetRepository, CartService $cartService, Request $request, CityRepository $cityRepository): Response
    {
        $search = new ArticleSearch();
        $form = $this->createForm(ArticleSearchType::class,$search);
        $payment = new Payment();
        $formPayment = $this->createForm(Payment1Type::class,$payment);
        if ($request->request->count() > 0) {
            $cartService->addPost($request->request->get('article_id'),$request->request->get('qty'));
            $this->addFlash('success','panier modiifer');
            return $this->redirectToRoute('cart_index');
        }

        $deliverySpace = new DeliverySpace();
        $formDeliverySpace = $this->createForm(DeliverySpaceType::class, $deliverySpace);
        $formDeliverySpace->handleRequest($request);
        return $this->renderForm('leSekoya/cart/index.html.twig',[
            'items'=>$cartService->getFullCart(),
            'total'=>$cartService->getTotal(),
            'form'=>$form,
            'cities'=>$cityRepository->findbyCountryName(),
            'streets'=>$streetRepository->findbyCity(),
            'form_payment'=>$formPayment,
            'form_delivery_space'=>$formDeliverySpace
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