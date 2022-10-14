<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\ArticleSearch;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticleSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mots',SearchType::class,[
                'label'=>false,
                'attr'=>[
                    'id'=>'searchBox',
                    'class'=>'form-primary rounded s',
                    'placeholder'=>'Recherche'
                ],
                'required'=>false
            ])
            ->add('maxPrice',IntegerType::class,[
                'required'=>false,
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Prix Max',
                    'class'=>'form-primary'
                ]
            ])
            ->add('minPrice',IntegerType::class,[
                'required'=>false,
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Prix Min',
                    'class'=>'form-primary'
                ]
            ])
            ->add('brand',TextType::class,[
                'required'=>false,
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Marque',
                    'class'=>'form-primary'
                ]
            ])
            ->add('etat',TextType::class,[
                'required'=>false,
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Etat',
                    'class'=>'form-primary'
                ]
            ])
            // ->add('category',EntityType::class,[
            //     'class'=>Category::class,
            //     // 'query_builder'=>function(EntityRepository $entityRepository){
            //     //     return $entityRepository->createQueryBuilder('p')
            //     //     ->where('is_anabled = true');
            //     // },
            //     'choice_label'=>'title',
            //     'label'=>false,
            //     'required'=>false,
            //     'attr'=>[
            //         'class'=>'form-primary',  
            //     ],
            //     'placeholder'=>'All articles'
            // ])
        ;
    }
    public function getCats(){
        return 
        [
            'Ordinateur'=>'ordinateur'
        ];
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArticleSearch::class,
            'method'=>'get',
            'csrf_protection'=>false,
             'translation_domain'=>'forms',

        ]);
    }
   public function getBlockPrefix(){
        return '';
    }
}