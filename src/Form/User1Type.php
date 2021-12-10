<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('personne',PersonneType::class,[
                'label'=>false
            ])
            ->add('email',EmailType::class,[
                'attr'=>[
                    'placeholder'=>'Email'
                ]
            ])
            ->add('adresse',TextType::class)
            ->add('roles',ChoiceType::class,[
                'attr'=>[
                    'placeholder'=>'Roles'
                ],
                'choices'=>User::roles,
                'multiple'=>true
            ])
            ->add('password',PasswordType::class,[
                'attr'=>[
                    'placeholder'=>'Mot de passe',
                    'value'=>'sekoya'.rand(0,900)
                ]
            ])

            ->add('phone_number',NumberType::class,[
                'attr'=>[
                    'placeholder'=>'Téléphone'
                ]
            ])
            ->add('isVerified')
            ->add('sendEmail',CheckboxType::class,[
                'mapped'=>false,
                'label'=>'Envoyez un email pour modifier le mot de passe ?'
            ])
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