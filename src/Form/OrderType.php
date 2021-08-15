<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('number',IntegerType::class,[
            //     'attr'=>[
            //         ''
            //     ],
            //     'help'=>'Number of order'
            // ])
            ->add('note')
            ->add('state',ChoiceType::class,[
                'choices'=>[
                    'new'=>'new',
                    'fulfilled'=>'fulfilled'
                ]
            ])
            // ->add('checkout_completed_at')
            // ->add('total')
            ->add('checkout_state',ChoiceType::class,[
                'choices'=>[
                    'incomplet'=>'incomplet',
                    'completed'=>'completed'
                ]
            ])
            ->add('payment_state',ChoiceType::class,[
                'choices'=>[
                    'awaiting_payment'=>'awaiting_payment',
                    'Paid'=>'Paid'
                ]
            ])
            ->add('shipping_state',ChoiceType::class,[
                'choices'=>[
                    'Ready'=>'Ready',
                    'shipped'=>'shippedd'
                ]
            ])
            ->add('shipping_adress',AdressType::class,[
                'label'=>false
            ])
            ->add('user',EntityType::class,[
                'class'=>User::class,
                'choice_label'=>'personne.lastName'
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}