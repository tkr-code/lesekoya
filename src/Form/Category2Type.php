<?php

namespace App\Form;

use App\Entity\Category2;
use App\Entity\Category3;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Category2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('category3',EntityType::class,[
                'class'=>Category3::class,
                'choice_label'=>'title',
                'placeholder'=>'Séléctionner le Niveau 3',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category2::class,
        ]);
    }
}
