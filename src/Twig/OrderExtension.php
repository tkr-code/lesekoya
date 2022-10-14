<?php

namespace App\Twig;

use App\Repository\CommentRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\OrderRepository;
use App\Service\Cart\CartService;

class OrderExtension extends AbstractExtension
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('orderUser', [$this, 'orderUser']),
        ];
    }

    public function orderUser(User $user,string $state= ''){
        if(empty($state)){
            return $this->orderRepository->findClient($user->getId());
        }else{
            if($state == 'in progress')
            {
                return $this->orderRepository->findClientState($user->getId());
            }else{
                return $this->orderRepository->findClientState($user->getId(),$state);
            }
        }
    }

   
}
