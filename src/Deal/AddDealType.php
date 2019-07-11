<?php

namespace App\Deal;

use App\Entity\Card;
use App\Entity\Deal;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddDealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('card', EntityType::class, [
                'class' => Card::class,
                'choice_label' => 'customerCode',
                'label' => 'addeal.card.label',
                'translation_domain' => 'forms'
            ])
            ->add('deal', EntityType::class, [
                'class' => Deal::class,
                'choice_label' => 'name',
                'label' => 'addeal.deal.label',
                'translation_domain' => 'forms'
            ])
            ;
    }
}