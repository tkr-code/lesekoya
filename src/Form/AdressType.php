<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name')
            ->add('last_name')
            ->add('phone_number')
            ->add('street')
            ->add('company')
            ->add('city')
            ->add('postal_code')
            // ->add('created_at')
            // ->add('updated_at')
            ->add('country_code')
            ->add('province_code')
            ->add('province_name')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
             'translation_domain'=>'forms',

        ]);
    }
}