<?php
/**
 * Created by PhpStorm.
 * User: Corinne
 * Date: 18/07/2019
 * Time: 08:42
 */

namespace App\Form;

use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;
use App\Entity\Card;

/**
 * Class LostTypeCard
 * @package App\Form
 */
class LostTypeCard extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $store = $options['store'];
        $builder
            ->add('customers', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (UserRepository $er) {
                    return $er->searchByRolesQb(['ROLE_USER']);
                },
                'required' => false,
                'translation_domain' => 'forms',
                'label' => 'lost_card.select.label.customer',
                'placeholder' => 'lost_card.select.placeholder.customer',
            ])
            ->add('cards', EntityType::class, [
                'class' => Card::class,
                'choices' => null,
                'required' => false,
                'translation_domain' => 'forms',
                'label' => 'lost_card.select.label.card',
                'placeholder' => 'lost_card.select.placeholder.card',
                'choice_label' => function ($card) {
                    return $card->getCompleteCode();
                }
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
        $resolver->setRequired([
            'store'
        ]);
    }
}