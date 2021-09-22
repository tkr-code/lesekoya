<?php 
namespace App\Service\Shipping;

use App\Repository\StreetRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ShippingService{
    private $session;
    private $streetRepository;
    public function __construct(StreetRepository $streetRepository, SessionInterface $sessionInterface)
    {
        $this->session =$sessionInterface;
    }
    public function addPost(int $id, int $qty)
    {
        $shipping = $this->session->get('shipping',[]);
        $shipping[$id]=$qty;
        
        $this->session->set('shipping',$shipping);
        // dd($shipping);
        
    }
    public function add(int $id)
    {
        $shipping = $this->session->get('shipping',[]);
        if(!empty($shipping[$id])){
            $shipping[$id]++;
        }else{
            $shipping[$id] = 1;
        }
        
        $this->session->set('shipping',$shipping);
        // dd($this->session->get('shipping'));
        
    }
    public function remove(int $id)
    {
        $shipping = $this->session->get('shipping',[]);

        if(!empty($shipping[$id])){
            $shipping[$id]--;
        }else{
            $shipping[$id] = 1;
        }
        
        $this->session->set('shipping',$shipping);
        
    }
    public function delete(int $id)
    {
        $shipping = $this->session->get('shipping',[]);

        if(!empty($shipping[$id])){
            unset($shipping[$id]);
        }
        $this->session->set('shipping',$shipping);
    }
    public function clear()
    {
        $this->session->set('shipping',[]);
    }

}