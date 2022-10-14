<?php

namespace App\Form;

use App\Entity\Adress;
use App\Entity\User;
use App\Entity\Order;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $user =  $options['user'];
        $builder
            // ->add('created_at',DateType::class,[
            //     'label'=>'Date'
            // ])
            // ->add('state',ChoiceType::class,[
            //     'choices'=>Order::status
            // ])
            ->add('note',TextareaType::class)            
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
            'translation_domain'=>'forms',
            'user'=>null
        ]);
    }
}