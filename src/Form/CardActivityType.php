<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Card;
use App\Entity\CardActivity;
use App\Repository\CardRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isTheWinner', ChoiceType::class,
                [
                    'label' => 'Match gagné',
                    'choices' => [
                        'Oui' => 1,
                        'Non' => 0
                    ]

                ])
            ->add('personalScore', IntegerType::class,
                [
                    'label' => 'Points gagnés lors du jeu',

                ])
            ->add('card', EntityType::class,
                [
                    'class' => Card::class,
                    'label' => 'Numéro de la carte',
                    'query_builder' => function(CardRepository $cardRepository){
                    return $cardRepository->createQueryBuilder('c')
                        ->join('c.user','cu' );
                    },
                    'choice_label' => 'CardOwnerName'
                ]
                )
            ->add('activity', EntityType::class,
                [
                    'class' => Activity::class,
                    'label' => 'Nom de l\'activité',
                    'choice_label' => 'gameName'
                ])
            ->add('gameDate', DateType::class,
                [
                    'label' => 'Date du jeu',
                    'required' => true,
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'html5' => true
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CardActivity::class,
        ]);
    }
}
