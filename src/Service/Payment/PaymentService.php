<?php 
    namespace App\Service\Payment;

use App\Repository\PaymentRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Order;
use App\Entity\Payment;

class PaymentService{
    private $em;

    private $repository;
    
    public function __construct(EntityManagerInterface $manager, PaymentRepository $repository)
    {
        $this->em = $manager;
        $this->repository = $repository;
    }
    public function calculPayment(Payment $payment)
    {
    
    //   return $payment;
    //   $payment->setAmount();
      $this->em->flush($payment);
    }
}