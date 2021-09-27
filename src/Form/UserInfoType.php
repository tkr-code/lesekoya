<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('email')
            // ->add('roles')
            // ->add('password')
            // ->add('isVerified')
            ->add('firstName',TextType::class,[
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'First name'
                ]
            ])
            ->add('lastName',TextType::class,[
                'required'=>true,
            ])
            ->add('avatar',FileType::class,[
                'label'=>'avatar ( jpg or png )  ',
                'multiple'=>false,
                'mapped'=>false,
                'required'=>false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image document',
                    ])
                ],
            ])
            // ->add('avatar')
            // ->add('created_at')
            // ->add('username')
            // ->add('phone_number')
            // ->add('favoris')
            // ->add('delivery_space')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
