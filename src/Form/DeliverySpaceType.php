<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\DeliverySpace;
use App\Entity\Street;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeliverySpaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('street',EntityType::class,[
                'class'=>Street::class,
                'choice_label'=>'name'
            ])
            ->add('client',EntityType::class,[
                'class'=>Client::class,
                'choice_label'=>function ($client){
                    return $client->getUser()->getFullName().' '.$client->getUser()->getFullName().' '.$client->getUser()->getEmail();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DeliverySpace::class,
        ]);
    }
}
