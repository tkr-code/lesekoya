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

class ClientEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name', TextType::class, [
                'label' => 'Prénom *',
                'attr' => [
                    'placeholder' => "prénom",
                ]
            ])
            ->add('last_name', TextType::class, [
                'label' => 'Nom *',
                'attr' => [
                    'placeholder' => 'Nom',
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email *'
            ])
            ->add('phone_number', NumberType::class, [
                'label' => 'Téléphone *'
            ])
            ->add('adresse', AdresseType::class, [
                'attr' => [
                    'placeholder' => 'Adresse'
                ],
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'forms',

        ]);
    }
}
