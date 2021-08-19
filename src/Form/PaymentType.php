<?php

namespace App\Form;

use App\Entity\Payment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount',IntegerType::class)
            ->add('state',ChoiceType::class,[
                'choices'=>[
                    'Canceled'=>'canceled',
                    'Waiting'=>'waiting',
                    'in progress'=>'in progress'
                ]
            ])
            ->add('details',TextareaType::class)
            // ->add('created_at')
            // ->add('updated_at')
            // ->add('order_payment')
            // ->add('paymentMethod')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}