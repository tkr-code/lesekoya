<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\ArticleBuy;
use App\Entity\Client;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleBuyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price')
            ->add('quantity')
            ->add('article',EntityType::class,[
                'class'=>Article::class,
                'choice_label'=>'title'
            ])
            ->add('client',EntityType::class,[
                'class'=>Client::class,
                'choice_label'=>function($client){
                    return $client->getUser()->getEmail().' - '.
                    $client->getUser()->getPersonne()->getFirstName().' '.
                    $client->getUser()->getPersonne()->getLastName();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArticleBuy::class,
        ]);
    }
}
