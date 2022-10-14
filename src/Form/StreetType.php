<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\ShippingAmount;
use App\Entity\Street;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StreetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('city',EntityType::class,[
                'class'=>City::class,
                'choice_label'=>'name'
            ])
            ->add('shipping_amount',EntityType::class,[
                'class'=>ShippingAmount::class,
                'choice_label'=>'amount'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Street::class,
        ]);
    }
}