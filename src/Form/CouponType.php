<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Coupon;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CouponType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('debut',DateType::class)
            ->add('fin',DateType::class)
            ->add('valeur',ChoiceType::class,[
                'label'=>'Reduction',
                'choices'=>Article::reductions(),
                'required'=>false,
                'placeholder'=>'Reduction',
                'attr'=>[
                    'class'=>'select2'
                ]
            ])
            ->add('status',ChoiceType::class,[
                'label'=>'Status',
                'choices'=>Coupon::STATU,
                'required'=>false,
                'placeholder'=>'Statu',
                'attr'=>[
                    'class'=>'select2'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Coupon::class,
        ]);
    }
}
