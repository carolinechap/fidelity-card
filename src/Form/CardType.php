<?php

namespace App\Form;

use App\Entity\Card;
use App\Entity\Store;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add(
             //   'user',
             //   EntityType::class,
             //   [
              //      'class' => User::class,
               //     'label' => 'Client',
              //      'choice_label' => function (User $user) {
                //        return $user->getFullname();
               //     },
                //    'expanded' => false,
                 //   'multiple' => false,
               // ]
           // )

            ->add(
                'store',
                EntityType::class,
                [
                    'class' => Store::class,
                    'label' => 'Centre laser game',
                    'choice_label' => 'name',
                    'expanded' => false,
                    'multiple' => false,
                ]
            )

            ->add('checkSum',
                TextType::class, [
                'label' => 'Code carte',
                'attr' => [
                    'readonly' => true,
                    'required' => false,
                    'mapped' => false,
                    //'hidden' => true
            ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
