<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Payment;
use App\Entity\PaymentMethod;
use App\Entity\Street;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class Payment1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('amount',IntegerType::class)
            // ->add('shippindAdress',ChoiceType::class,[
            //     'choices'=>[
            //         'In progress'=>'in progress',
            //         'Canceled'=>'canceled',
            //         'Waiting'=>'waiting'
            //     ],
            //     'attr'=>[
            //         'value'=>'In progress'
            //     ],
            //     'mapped'=>false
            // ])            
            ->add('paymentMethod',EntityType::class,[
                'class'=>PaymentMethod::class,
                'choice_label'=>'name',
                'attr'=>[
                    'required'=>true
                ]
                ])
                // ->add('city',EntityType::class,[
                //     'class'=>Street::class,
                //     'choice_label'=>'name',
                //     'mapped'=>false,
                //     'label'=>'Lieu de livraison'
                // ])
                ->add('country',EntityType::class,[
                    'class'=>Country::class,
                    'choice_label'=>'name',
                    'mapped'=>false,
                    'label'=>'Pays'
                ])
                ;
            // ->add('details',TextareaType::class,[
            //     'attr'=>[
            //     ],
            //     'required'=>false
            // ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
            'translation_domain'=>'forms',
        ]);
    }
}