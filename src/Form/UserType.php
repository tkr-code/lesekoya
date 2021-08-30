<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',TextType::class,[
                'attr'=>[
                    'placeholder'=>'email'
                ],
                'placeholder'=>'email'
            ])
            // ->add('roles')
            ->add('password')
            // ->add('isVerified')
            // ->add('personne')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
             'translation_domain'=>'forms',

        ]);
    }
}