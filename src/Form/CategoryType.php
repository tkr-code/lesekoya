<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\ParentCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Enter category'
                ],
            ])
            // ->add('parent_category',EntityType::class,[
            //     'class'=>ParentCategory::class,
            //     'required'=>false,
            //     'choice_label'=>'name'
            // ])
            ->add('is_active')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
             'translation_domain'=>'forms',

        ]);
    }
}