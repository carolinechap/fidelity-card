<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname',
            TextType::class,
            ['label' => 'Prénom']
            )
            ->add('firstname',
                TextType::class,
                ['label' => 'Nom']
            )
            ->add('email',
                EmailType::class,
                ['label' => 'Email']
            )
            ->add('plainPassword',
                RepeatedType::class,
                ['type' => PasswordType::class,
                    'first_options' => [ 'label' => 'Mot de passe'],
                    'second_options' => ['label' => 'Confirmation du mot de passe'],
                    'invalid_message' => 'La confirmation doit correspondre au mot de passe'
                    ]
            )
            ->add('numberStreet',
                TextType::class,
                ['label' => 'Numéro de la rue']
                )
            ->add('nameStreet',
                TextType::class,
                ['label' => 'Nom de la rue']
            )
            ->add('zipCode',
                TextType::class,
                ['label' => 'Code postal']
            )
            ->add('city',
                TextType::class,
                ['label' => 'Ville']
            )
            ->add('country',
                TextType::class,
                ['label' => 'Pays']
            )
           // ->add('has_card',
             //   CheckboxType::class,
               // [
                 //   'label' => 'Je détiens une carte de fidélité',
                   // 'required' => false
               // ]
          //  )
            //->add('customerCode')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
