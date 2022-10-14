<?php

namespace App\Controller\Admin;

use App\Repository\ArticleRepository;
use App\Repository\ClientRepository;
use App\Repository\OrderRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    private $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;   
    }
    /**
     * @Route("/", name="admin")
     */
    public function index(ClientRepository $clientRepository, OrderRepository $orderRepository, ArticleRepository $articleRepository, UserRepository $userRepository)
    {
        return $this->render('admin/dashboard/index.html.twig',[
            'title'=>'titre de la page',
            'productOnline'=>$articleRepository->findCountOnline(),
            'allArticle'=>count($articleRepository->findAll()),
            'orderInProgress'=>$orderRepository->findState('in progress'),
            'lastOrder'=>$orderRepository->findAllLast(),
            'orders'=>count($orderRepository->findAll()),
            'clients'=>$clientRepository->findAll(),
            'recentlys'=>$articleRepository->recently(),
            'parent_page'=>$this->translator->trans('Dashboard'),
            'latestUser'=>$userRepository->findByRole('ROLE_USER'),
            'gerants'=>$userRepository->findByRole('ROLE_EDITOR')
        ]);
    }
    /**
     * @Route("/dashboard", name="admin2")
     */
    public function index2()
    {
        return $this->render('admin/dashboard/index2.html.twig',[
            'parent_page'=>$this->translator->trans('Dashboard 2')
        ]);
    }
        
    // /**
    //  * @Route("/profile/{id<\d+>?0}", name="profile_index", methods={"GET","POST"},
    //  * host="localhost", schemes={"http", "https"} )
    //  */
    // public function profileEdit(Request $request)
    // {
    //     // $user = $this->getUser();
    //     return $this->render("admin/profile.html.twig",[
            
    //     ]);
    // }
        
    /**
     * @Route("/profile/{id<\d+>?0}", name="profile_index", methods={"GET","POST"},
     * host="localhost", schemes={"http", "https"} )
     */
    public function profile(Request $request)
    {
        // $user = $this->getUser();
        return $this->render("admin/profile.html.twig",[
            'title'=>"mon profile - $this->nameApp",
            'id'=>$request->attributes->get('id'),
            'prenom'=>'Malick',
            'nom'=>'Tounkara'
        ]);
    }
    /**
     * @Route("/tableau-de-board",name="tableau-de-board")
     */
    public function dashBoard()
    {
      return  $this->render("admin/index.html.twig",[
          'title'=>"Titre de la page | $this->nameApp"
      ]);
    }
}