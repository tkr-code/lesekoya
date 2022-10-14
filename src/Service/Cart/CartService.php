<?php 
namespace App\Service\Cart;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService{
    private $session;
    private $articleRepository;
    public function __construct(SessionInterface $sessionInterface, ArticleRepository $articleRepository)
    {
        $this->session =$sessionInterface;
        $this->articleRepository = $articleRepository;
    }
    public function addPost(int $id, int $qty)
    {
        $panier = $this->session->get('panier',[]);
        $panier[$id]=$qty;
        
        $this->session->set('panier',$panier);
        // dd($panier);
        
    }
    public function add(int $id)
    {
        $panier = $this->session->get('panier',[]);
        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }
        
        $this->session->set('panier',$panier);
        
    }
    public function remove(int $id)
    {
        $panier = $this->session->get('panier',[]);

        if(!empty($panier[$id])){
            $panier[$id]--;
        }else{
            $panier[$id] = 1;
        }
        
        $this->session->set('panier',$panier);
        
    }
    public function delete(int $id)
    {
        $panier = $this->session->get('panier',[]);

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }
        $this->session->set('panier',$panier);
    }
    public function clear()
    {
        $this->session->set('panier',[]);
    }
    public function getFullCart(): array
    {
        $panier = $this->session->get('panier',[]);
        $panierWithData = [];
        foreach($panier as $id => $quantite){
            $panierWithData[]=[
                'article'=>$this->articleRepository->find($id),
                'quantite'=>$quantite
            ];
        }
        return $panierWithData;
    }
    public function getTotal():float
    {
        $total = 0;
        foreach ($this->getFullCart() as $item) {
                $total+= $item['article']->getNewPrice() * $item['quantite'];
        }
        // dd($this->getFullCart());
        return $total;
    }

}