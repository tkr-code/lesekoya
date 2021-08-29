<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('roles',ChoiceType::class,[
                'choices'=>[
                    // 'Utilisateur'=>'ROLE_USER',
                    'Administrateur'=>'ROLE_ADMIN',
                    'Editeur'=>'ROLE_EDITOR',
                    'Client'=>'ROLE_CLIENT'
                ],
                // 'expanded'=>true,
                'multiple'=>true,
                'attr'=>[
                    'class'=>'select2'
                ]
            ])
            // ->add('password')
            ->add('personne',PersonneType::class,[
                'label'=>false
                ])
            ->add('isVerified')
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