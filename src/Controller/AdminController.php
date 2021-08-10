<?php

namespace App\Controller;

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
    private $nameApp = 'Framework Tounkara';

    /**
     * @Route("/", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig',[
            'title'=>'titre de la page'
        ]);
    }
        
    // /**
    //  * @Route("/produit", name="admin_produit_index", methods={"GET"})
    //  */
    // public function produit(ProduitRepository $produitRepository): Response
    // {

    //     $produitsOn =$produitRepository->findAllOn();
    //     $countOn =  count($produitsOn);

    //     $produitsOff = $produitRepository->findAllOff();
    //     $countOff = count($produitsOff);
    //     return $this->render('admin/produit/index.html.twig', [
    //         'produits' => $produitRepository->findAll(),
    //         'produitsOn'=>$produitsOn,
    //         'countOn'=>$countOn,
    //         'produitsOff'=>$produitsOff,
    //         'countOff'=>$countOff,
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