<?php

namespace App\Form;

use App\Entity\Store;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('centerCode',
                TextType::class,
                [
                'label' => 'Code centre',
                'attr' => [
                    'readonly' => true
                ]
            ])
            ->add('numberStreet',
                TextType::class,
                [
                    'label' => 'Numéro'
                ]
            )
            ->add('nameStreet',
                TextType::class,
                [
                    "label" => 'Rue'
                ])
            ->add('zipCode',
                TextType::class,
                [
                    'label' => 'Code postal'
                ])
            ->add('city',
                TextType::class,
                [
                    'label' => 'Ville'
                ])
            ->add('country',
                TextType::class,
                [
                    'label' => 'Pays'
                ])
            ->add('name',
                TextType::class,
                [
                    'label' => 'Nom du centre'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Store::class,
        ]);
    }
}
