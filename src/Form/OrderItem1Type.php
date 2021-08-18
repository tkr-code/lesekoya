<?php

namespace App\Form;

use App\Entity\OrderItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderItem1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity')
            ->add('unit_price')
            ->add('units_total')
            ->add('adjustments_total')
            ->add('total')
            ->add('produit_name')
            ->add('variant_name')
            ->add('commande')
            ->add('article')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderItem::class,
        ]);
    }
}
