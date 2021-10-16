<?php

namespace App\Tests;

use App\Entity\Order;
use App\Repository\ClientRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class OrderTest extends TestCase
{
    public function testSomething(): void
    {
        $order  = new Order();
        $order->setNumber('0004');
        $order->setNote('Ma note');
        $order->setState('in progress');
        $order->setCheckoutCompletedAt(New \DateTime('+3 days'));
        $order->setTotal(200000);
        //user 
        // $user = $this->userRepository->find(1);
        // $order->setUser($user);
        dd($order);
        $this->assertTrue(true);
    }
}
