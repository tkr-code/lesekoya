<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Enter title'
                ],
                'help'=>'the product is unique and greater than 3 characters'
            ])
            ->add('buyingPrice',TextType::class,[
                'attr'=>[
                    'placeholder'=>'The price must be greater than zero'
                ],
                'help'=>'The price must be greater than zero'
            ])
            ->add('price',IntegerType::class,[
                'attr'=>[
                    'placeholder'=>'The price must be greater than zero'
                ],
                'help'=>'The price must be greater than zero'
            ])
            ->add('quantity',IntegerType::class,[
                'attr'=>[
                    'placeholder'=>'The quantity must be greater than zero'
                ],
                'help'=>'The quantity must be greater than zero'
            ])
            ->add('description',TextareaType::class,[
                'attr'=>[
                    'placeholder'=>'The descripsion greater 10 characters',
                ]
            ])
            ->add('etat',ChoiceType::class,[
                'choices'=>Article::etats,
                'required'=>false,
                'attr'=>[
                    'class'=>'select2'
                ]
            ])
            ->add('category',EntityType::class,[
                'class'=>Category::class,
                'choice_label'=>'title'
                ])
            ->add('images',FileType::class,[
                'label'=>false,
                'multiple'=>true,
                'mapped'=>false,
                'required'=>false
                ])
            ->add('enabled',CheckboxType::class,[
                'label'=>'Activer',
            ])
            ->add('saveAndAdd', SubmitType::class, [
                'label' => 'Save and Add',
                'attr'=>[
                    'class'=>'btn btn-info'
                ]
                ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'translation_domain'=>'forms',

        ]);
    }
}