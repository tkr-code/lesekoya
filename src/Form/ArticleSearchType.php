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

class ArticleSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mots',SearchType::class,[
                'label'=>false,
                'attr'=>[
                    'id'=>'searchBox',
                    'class'=>'form-control rounded s text-lowercase',
                    'placeholder'=>'Enter one or more keywords'
                ],
                'required'=>false
            ])
            ->add('maxPrice',IntegerType::class,[
                'required'=>false,
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Maximum budget'
                ]
            ])
            ->add('minPrice',IntegerType::class,[
                'required'=>false,
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Minimum budget'
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
            //         'class'=>'select2',  
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