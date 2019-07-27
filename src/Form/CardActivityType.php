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

/**
 * Class CardActivityType
 * @package App\Form
 */
class CardActivityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isTheWinner', ChoiceType::class,
                [
                    'translation_domain' => 'forms',
                    'label' => 'cardactivity.form.label.is_the_winner',
                    'choices' => [
                        'Oui' => 1,
                        'Non' => 0
                    ]
                ])
            ->add('personalScore', IntegerType::class,
                [
                    'translation_domain' => 'forms',
                    'label' => 'cardactivity.form.label.personal_score',

                ])
            ->add('card', EntityType::class,
                [
                    'class' => Card::class,
                    'translation_domain' => 'forms',
                    'label' => 'cardactivity.form.label.card_number',
                    'query_builder' => function (CardRepository $cardRepository) {
                        return $cardRepository->createQueryBuilder('c')
                            ->join('c.user', 'cu');
                    },
                    'choice_label' => 'CardOwnerName'
                ]
            )
            ->add('activity', EntityType::class,
                [
                    'class' => Activity::class,
                    'translation_domain' => 'forms',
                    'label' => 'cardactivity.form.label.game_name',
                    'choice_label' => 'gameName'
                ])
            ->add('gameDate', DateType::class,
                [
                    'translation_domain' => 'forms',
                    'label' => 'cardactivity.form.label.game_date',
                    'required' => true,
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'html5' => true
                ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CardActivity::class,
        ]);
    }
}
