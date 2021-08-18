<?php

namespace App\Tests;

use App\Repository\OrderRepository;
use PHPUnit\Framework\TestCase;

class OrderPostTest extends TestCase
{
    public function testSomething(OrderRepository $orderRepository): void
    {
    //    $test =  $orderRepository->findAll();
    //     dump($test);
        $this->assertTrue(true);
    }
}