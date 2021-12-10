<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,[
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Votre email',
                    'value'=>'client10@mail.com'
                ]
            ])
            ->add('phone_number',NumberType::class,[
                'attr'=>[
                    'placeholder'=>'Numéro de téléphone',
                    'value'=>'781278288'
                ],
                'label'=>false
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label'=>"J'acceptes les conditions",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label'=>false,
                // 'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'placeholder'=>'Mot de passe',
                    'value'=>'demarrer'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('password_verify', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                // 'mapped' => false
                'label'=>false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'placeholder'=>'Confirmation de mot de passe',
                    'value'=>'demarrerr'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('personne',PersonneType::class,[
                'label'=>false
            ])
            ->add('adresse',TextType::class,[
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Adresse, code postal'
                ],
            ])
            // ->add('adresses',Adress1Type::class,[
            //     'label'=>false,
            //     'mapped'=>false
            // ])
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