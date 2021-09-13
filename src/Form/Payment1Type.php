<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Country;
use App\Entity\Payment;
use App\Entity\PaymentMethod;
use App\Entity\ShippingAmount;
use App\Entity\Street;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;

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
                //  ->add('country',EntityType::class,[
                //     'class'=>Country::class,
                //     'choice_label'=>'name',
                //     'mapped'=>false,
                //     'label'=>false
                // ])
                ->add('city',EntityType::class,[
                    'class'=>City::class,
                    'query_builder'=>function(EntityRepository $entityRepository){
                        return $entityRepository->createQueryBuilder('a')
                        ->join('a.country', 'b')
                        ->where("b.name = 'Sénégal' ");
                    },
                    'choice_label'=>'name',
                    'mapped'=>false,
                    'label'=>false
                ])
                ->add('street',EntityType::class,[
                    'class'=>Street::class,
                    'query_builder'=>function(EntityRepository $entityRepository){
                        return $entityRepository->createQueryBuilder('a')
                        ->join('a.city', 'b')
                        ->where("b.name = 'Dakar' ");
                    },
                    'choice_label'=>'name',
                    'mapped'=>false,
                    'label'=>false
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