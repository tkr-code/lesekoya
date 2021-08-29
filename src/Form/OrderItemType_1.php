<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\OrderItem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderItemType_1 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity',IntegerType::class,[
                'attr'=>[
                    'value'=>1
                ]
            ])
            // ->add('produit_name')
            ->add('unit_price',IntegerType::class,[
                'attr'=>[
                    'value'=>0
                ],
                'help'=>"Si le prix est egal a zero (0), le prix de l'article selectionner sera enregistré "
            ])
            // ->add('units_total')
            // ->add('adjustments_total')
            // ->add('total')
            // ->add('is_immutable')
            // ->add('variant_name')
            // ->add('commande')
            ->add('article',EntityType::class,[
                'class'=>Article::class,
                'choice_label'=>'title'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderItem::class,
             'translation_domain'=>'forms',

        ]);
    }
}