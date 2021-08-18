<?php

namespace App\Form;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OrderNewType extends AbstractType
{
    private $orderRepository;
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number',TextType::class,[
                'attr'=>[
                    'disabled'=>true,
                    'value'=>$this->voiceNumber()
                ]
            ])
            ->add('note',TextareaType::class,[
                
            ])
            // ->add('state')
            // // ->add('checkout_completed_at')
            // // ->add('total',)
            // ->add('checkout_state')
            // ->add('payment_state')
            // ->add('shipping_state')
            // ->add('paymentDue',DateType::class)
            // // ->add('items_total')
            // // ->add('adjustments_total')
            // ->add('shipping')
            // ->add('shipping_adress')
            // ->add('user',EntityType::class,[
            //     'label'=>'user.personne.nom'
            // ])
            // ->add('payment')
        ;
    }

    public function voiceNumber()
    {
        $invoice= 1;
        $orders = $this->orderRepository->findLast();
        foreach($orders as $order)
        {
           $invoice += $order->getNumber();
        }
        return   sprintf("%06s", $invoice);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}