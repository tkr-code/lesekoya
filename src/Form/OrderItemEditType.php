<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\OrderItem;
use App\Repository\ArticleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class OrderItemEditType extends AbstractType
{
    private $repository;
    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('article',EntityType::class,[
                    'class'=>Article::class,
                    'choice_label'=>'title',
                    'attr'=>[
                        'disabled'=>true
                    ]
                    
                ])
            ->add('quantity',IntegerType::class,[
                'attr'=>[
                    'value'=>1
                ]
            ])
            // ->add('produit_name')
            // ->add('unit_price',IntegerType::class,[
            //     'attr'=>[
            //         'value'=>0
            //     ],
            //     'help'=>"Si le prix est egal a zero (0), le prix de l'article selectionner sera enregistré "
            // ])
            // ->add('units_total')
            // ->add('adjustments_total')
            // ->add('total')
            // ->add('produit_name')
            // ->add('variant_name')
            // ->add('commande')
        ;
    }
    public function articleNotOrderItem()
    {
        
        
        return $this->repository->findAll();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderItem::class,
             'translation_domain'=>'forms',

        ]);
    }
}