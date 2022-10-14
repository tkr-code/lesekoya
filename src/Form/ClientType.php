<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('personne',PersonneClientType::class,[
                'label'=>false
            ])
            ->add('email',EmailType::class,[
                'label'=>'Email *'
            ])
            ->add('phone_number',NumberType::class,[
                'label'=>'Téléphone *'
            ])
            ->add('adresse',AdresseType::class,[
                'attr'=>[
                    'placeholder'=>'Adresse'
                ],
                'required'=>false
            ])
            ->add('password',PasswordType::class,[
                'label'=>'Mot de passe *'
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
