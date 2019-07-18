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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Entity\Card;
use Symfony\Component\Form\FormInterface;

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
                'query_builder' => function (UserRepository $er) use ($store) {
                    return $er->getCustomers($store);
                },
                'required' => true,
                'translation_domain' => 'forms',
                'label' => 'card.lost.select.label.customer',
                'placeholder' => 'card.lost.select.placeholder.customer',
                'compound' => true
            ]);

        $formModifier = function (FormInterface $form, $customer) {
            $cards = $customer  === null ? [] : $customer->getCards();
            $form->add('cards', EntityType::class, [
                'class' => Card::class,
                'choices' => $cards,
                'required' => false,
                'translation_domain' => 'forms',
                'label' => 'card.lost.select.label.card',
                'placeholder' => 'card.lost.select.placeholder.card'
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                if (null !== $event->getData()) {
                    // we don't need to add the friend field because
                    // the message will be addressed to a fixed friend
                    return;
                }
                $customer = $event->getData();
                $formModifier($event->getForm(), $customer);
            }
        );

        $builder->get('customers')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $customer = $event->getForm()->getData();;
                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $customer);
            }
        );
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