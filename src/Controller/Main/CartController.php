<?php

namespace App\Controller\Main;

use App\Entity\Payment;
use App\Entity\User;
use App\Form\Payment1Type;
use App\Form\RegistrationFormType;
use App\Entity\ArticleSearch;
use App\Entity\DeliverySpace;
use App\Form\ArticleSearchType;
use App\Form\DeliverySpaceType;
use App\Service\Cart\CartService;
use App\Repository\CityRepository;
use App\Repository\StreetRepository;
use App\Repository\ArticleRepository;
use App\Repository\PaymentMethodRepository;
use App\Repository\ShippingAmountRepository;
use App\Service\Shipping\ShippingService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $cartService;
    private $shippingService;
    public function __construct(CartService $cartService, ShippingService $shippingService)
    {
        $this->cartService = $cartService;
        $this->shippingService = $shippingService;
    }
    /**
     * checkout
     * @Route("/checkout", name="checkout")
     * @return void
     */
    public function checkout():Response
    {
        return $this->render('lesekoya/cart/checkout.html.twig',[

        ]);
    }
    /**
     * cart
     * @Route("/cart/order-step-1", name="cart_step_1")
     * @return void
     */
    public function step1(SessionInterface $sessionInterface, PaymentMethodRepository $paymentMethodRepository, StreetRepository $streetRepository, ShippingService $shippingService, ShippingAmountRepository $shippingAmountRepository, Request $request):Response
    {
        $user = new User();
        $formRegistration = $this->createForm(RegistrationFormType::class, $user);
        // recupere la rue
        $street = $sessionInterface->get('shipping');
        // on recuppere le montant corespondant
        if($request->request->count() > 0 )
        {
            $methodPaiement = $request->request->get('method');
            $sessionInterface->set('methodPayment',$methodPaiement);

        }
        if($sessionInterface->get('methodPayment'))
        {
            $methodPaiement = $sessionInterface->get('methodPayment');
        }
        else{
            return $this->redirectToRoute('cart_index');
        }
        
        //on recupere la methode de paiment
        // on recupere le total du panier
        //on gener la nouvelle commande avec le prix de la livraion
        return $this->renderForm('lesekoya/cart/order-step-1.html.twig',[
            'items'=>$this->cartService->getFullCart(),
            'subtotal'=>$this->cartService->getTotal(),
            'street'=>$street,
            'registrationForm'=>$formRegistration,
            'methodPayment'=>$paymentMethodRepository->find($methodPaiement)


        ]);
    }
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index( PaymentMethodRepository $paymentMethodRepository, ArticleRepository $articleRepository,StreetRepository $streetRepository, CartService $cartService, Request $request, CityRepository $cityRepository): Response
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
            'form_delivery_space'=>$formDeliverySpace,
            'rand_articles'=>$articleRepository->findRand(),
            'methodPayment'=>$paymentMethodRepository->findAll()

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
     * @Route("/cart/shipping/add/{id}", name="shipping_add")
     */
    public function addShipping(int $id, ShippingService $shippingService )
    {
        $shippingService->add($id);
        return $this->redirectToRoute('cart_index');
    }
    /**
     * @Route("/cart/remove/{id}", name="cart_remove", methods="GET")
     */
    public function remove($id, CartService $cartService)
    {
        $cartService->remove($id);
        $this->addFlash('success','Le produit a été retiré du panier');
        return $this->redirectToRoute('cart_index');
    }
    /**
     * @Route("/cart/delete/{id}", name="cart_delete", methods="GET")
     */
    public function delete($id, CartService $cartService)
    {
        $cartService->delete($id);
        $this->addFlash('success','Le produit retiré du panier');
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