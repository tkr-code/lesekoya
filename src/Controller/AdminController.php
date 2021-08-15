<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    
    public function __construct()
    {
        $this->gestions = [
            [
                'name'=>'Category',
                'path'=>'category_index',
                'icon'=>'far fa-circle nav-icon'
            ]
        ];
    }
    private $nameApp = 'Framework Tounkara';

    /**
     * @Route("/", name="admin")
     */
    public function index(ArticleRepository $articleRepository)
    {
        return $this->render('admin/index.html.twig',[
            'title'=>'titre de la page',
            'productOnline'=>$articleRepository->findCountOnline()

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