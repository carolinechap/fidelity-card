<?php

namespace App\Form;

use App\Entity\Activity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('personalScore', IntegerType::class,
                [
                    'label' => 'Points gagnés lors du jeu',

                ])
            //->add('fidelityPoint')
            ->add('gameDate', DateType::class,
                [
                    'label' => 'Date du jeu',
                    'required' => false,
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'html5' => false
                ])
            ->add('isTheWinner', ChoiceType::class,
                [
                    'label' => 'Match gagné',
                    'choices' => [
                        'Oui' => 1,
                        'Non' => 0
                    ]

                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
