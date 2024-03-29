<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\File;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
class ArticleType extends AbstractType
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,[
                'label'=>'Nom du produit (*)',
                'attr'=>[
                    'placeholder'=>'Enter title'
                ],
                // 'help'=>'the product is unique and greater than 3 characters'
            ])
            ->add('detail',TextType::class,[
                'label'=>'Détail (*)',
                'attr'=>[
                    'placeholder'=>'Entrer les détails'
                ],
            ])
            ->add('buyingPrice',TextType::class,[
                'label'=>"Prix d'achat (*)",
                'attr'=>[
                    'placeholder'=>'The price must be greater than zero'
                ],
                'help'=>'The price must be greater than zero'
            ])
            ->add('price',IntegerType::class,[
                'label'=>'Prix de vente (*)',
                'attr'=>[
                    'placeholder'=>'The price must be greater than zero'
                ],
                'help'=>'The price must be greater than zero'
            ])
            ->add('reduction',ChoiceType::class,[
                'label'=>'Reduction',
                'choices'=>Article::reductions(),
                'required'=>false,
                'attr'=>[
                    'class'=>'select2'
                ],
                'placeholder'=>'Séléctionner une Pourcentage'
                // 'attr'=>[
                //     'placeholder'=>'The price must be greater than zero'
                // ],
                // 'help'=>'The price must be greater than zero'
            ])
            ->add('quantity',IntegerType::class,[
                'label'=>'Quantité (*)',
                'attr'=>[
                    'placeholder'=>'The quantity must be greater than zero'
                ],
                'help'=>'The quantity must be greater than zero'
            ])
            ->add('description',CKEditorType::class,[
                'label'=>'Description (*)',
                'attr'=>[
                    'placeholder'=>'The descripsion greater 10 characters',
                ],
                // 'config'=>[
                //     ''
                // ]
            ])

            ->add('status',ChoiceType::class,[
                'label'=>'Etat',
                'placeholder'=>"Séléctionner l'état",
                'choices'=>Article::STATUS,
                'attr'=>[
                    'class'=>'select2'
                ],
            ])

            ->add('label',ChoiceType::class,[
                'label'=>'Eticket',
                'choices'=>Article::LABEL,
                'required'=>false,
                'placeholder'=>"Séléctionner l'éticket",
                'attr'=>[
                    'class'=>'select2'
                    ]
                ])
            ->add('brand',EntityType::class,[
                'label'=>'Marque',
                'required'=>false,
                'class'=>Brand::class,
                'choice_label'=>'name',
                'placeholder'=>'Séléctionner la marque',

                ])
            ->add('category',EntityType::class,[
                'label'=>'Catégorie (*)',
                'class'=>Category::class,
                'choice_label'=>'title',
                'placeholder'=>'Séléctionner la catégorie'
                ])
            ->add('images',FileType::class,[
                'label'=>'Ajouter une ou plusieurs images (*)',
                'multiple'=>'multiple',
                'mapped'=>false,
                'constraints'=>[],
                ])
            ->add('fournisseur',EntityType::class,[
                'label'=>'Fournisseur',
                'class'=>User::class,
                'query_builder'=>function(EntityRepository $entityRepository){
                    $role = 'ROLE_FOURNISSEUR';
                     return $entityRepository->createQueryBuilder('q')
                            ->select('u')
                            ->from(User::class, 'u')
                            ->where('u.roles LIKE :roles')
                            ->setParameter('roles', '%"'.$role.'"%');
                },
                'choice_label'=>function($user){
                    return $user->getFullName().' - '.$user->getEmail();
                },
                'placeholder'=>'Séléctionner le fournisseur'
            ])
            ->add('enabled',CheckboxType::class,[
                'label'=>'Activer',
            ])
        ;
        // $formModififer = function(FormInterface $form, Category $category = null){
        //     $brands = null === $category ? [] : $category->getBrands();
        //     // dd($brands);
        //     $form->add('brand',EntityType::class,[
        //         'class'=>Brand::class,
        //         'placeholder'=>'',
        //         'choices'=>$brands
        //     ]);
        // };

        // $builder->addEventListener(
        //     FormEvents::POST_SET_DATA,
        //     function(FormEvent $event) use ($formModififer){
        //         $data = $event->getData();
        //         dump($data);
        //         $formModififer($event->getForm(), $data->getCategory());
        //     }
        // );

        // $builder->get('category')->addEventListener(
        //     FormEvents::POST_SUBMIT,
        //     function(FormEvent $event) use ($formModififer){
        //         $category  = $event->getForm()->getData();
        //         $formModififer($event->getForm()->getParent(),$category);
        //     }
        // );

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'translation_domain'=>'forms',

        ]);
    }

}