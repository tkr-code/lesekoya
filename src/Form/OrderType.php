<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('created_at',DateType::class,[
                'label'=>'Date'
            ])
            // ->add('number',IntegerType::class,[
            //     'attr'=>[
            //         ''
            //     ],
            //     'help'=>'Number of order'
            // ])
            
            ->add('state',ChoiceType::class,[
                'choices'=>[
                    'Completed'=>'completed',
                    'Canceled'=>'canceled',
                    'Waiting'=>'waiting',
                    'in progress'=>'in progress'
                ]
            ])
            ->add('note',TextareaType::class)
            // ->add('user',EntityType::class,[
            //     'class'=>User::class,
            //     'choice_label'=>'personne.lastName',
            //     'attr'=>[
            //         'disabled'=>true
            //     ]
            // ])
            // ->add('checkout_completed_at')
            // ->add('total')
            // ->add('checkout_state',ChoiceType::class,[
            //     'choices'=>[
            //         'incomplet'=>'incomplet',
            //         'completed'=>'completed'
            //     ]
            // ])
            // ->add('payment_state',ChoiceType::class,[
            //     'choices'=>[
            //         'awaiting_payment'=>'awaiting_payment',
            //         'Paid'=>'Paid'
            //     ]
            // ])
            ->add('shipping_state',ChoiceType::class,[
                'choices'=>[
                    'Ready'=>'Ready',
                    'shipped'=>'shippedd'
                ]
            ])
            // ->add('shipping_adress',AdressType::class,[
            //     'label'=>false
            // ])
            
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}