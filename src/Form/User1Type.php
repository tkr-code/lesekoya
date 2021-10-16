<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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
            ->add('email',EmailType::class)
            ->add('roles',ChoiceType::class,[
                'choices'=>[
                    'Administrateur'=>'ROLE_ADMIN',
                    'Editeur'=>'ROLE_EDITOR',
                    'Client'=>'ROLE_CLIENT',
                    'Utilisateur'=>'ROLE_USER'
                ],
                'multiple'=>true
            ])
            ->add('password',PasswordType::class)

            ->add('phone_number')
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