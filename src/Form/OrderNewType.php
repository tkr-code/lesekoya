<?php

namespace App\Form;

use App\Entity\Adress;
use App\Entity\Article;
use App\Entity\DeliverySpace;
use App\Entity\Order;
use App\Entity\Payment;
use App\Entity\PaymentMethod;
use App\Entity\Shipping;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OrderNewType extends AbstractType
{
    private $orderRepository;
    private $articleRepository;
    public function __construct(OrderRepository $orderRepository, ArticleRepository $articleRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->articleRepository = $articleRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('number',TextType::class,[
            //     'attr'=>[
            //         'disabled'=>true,
            //         'value'=>$this->voiceNumber()
            //     ]
            // ])
            ->add('note',TextareaType::class,[
                'attr'=>[
                    'placeholder'=>'Des recommandations pour cette commande ? ...'
                ],
            ])
            // ->add('state',ChoiceType::class,[
            //     'choices'=>[
            //         'in progress'=>'in progress',
            //         'Canceled'=>'canceled',
            //         'Waiting'=>'waiting',
            //     ],
            //     'attr'=>[
            //         'value'=>'in progress'
            //     ],
            //     'label'=>'state order'
            // ])
            // // ->add('checkout_completed_at')
            // // ->add('total',)
            // ->add('checkout_state')
            // ->add('payment_state')
            // ->add('shipping_state')
            // ->add('paymentDue',DateType::class)
            // // ->add('items_total')
            // // ->add('adjustments_total')
            ->add('delivery_space',EntityType::class,[
                'class'=>DeliverySpace::class,
                'attr'=>[
                    'value'=>0
                ],
                'choice_label'=>function($deliverySpace){
                    return $deliverySpace->getStreet()->getName().' Montant: '.$deliverySpace->getStreet()->getshippingAmount()->getAmount()." XOF";
                }
            ])
            // ->add('shipping_adress',EntityType::class,[
            //     'class'=>Adress::class
            // ])
            ->add('user',EntityType::class,[
                'class'=>User::class,
                'query_builder'=> function(EntityRepository $entityRepository){
                    return $entityRepository->createQueryBuilder('p')
                    ->where('p.id <> 1 ');
                },
                'choice_label'=>'email'
            ])
            // ->add('order_item',EntityType::class,[
            //     'class'=>Article::class,
            //     'query_builder'=> function(EntityRepository $entityRepository){
            //         return $entityRepository->createQueryBuilder('p')
            //         ->where('p.enabled = true ');
            //     },
            //     'choice_label'=>'title',
            //     'multiple'=>true,
            //     'attr'=>[
            //         'class'=>'select2',
            //         'placeholder'=>'Select articles',
            //         'required'=>true,
            //     ],
            //     'label'=>'Add articles',

            // ])
            ->add('payment',PaymentType::class,[
                'label'=>false
            ])
        ;
    }

    public function getArticles()
    {
        
        $categories =  $this->articleRepository->findAllOn();
        $k= 0;
        $list = [];
        foreach($categories as  $v){
            $list[$v->getTitle()] = $v->getId();
        }
        return $list;
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
             'translation_domain'=>'forms',

        ]);
    }
}