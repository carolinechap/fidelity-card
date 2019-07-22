<?php

namespace App\Form;

use App\Entity\Deal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DealType
 * @package App\Form
 */
class DealType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'translation_domain' => 'forms',
                'label' => 'deal.form.label.name'
            ])
            ->add('startDate',DateType::class, [
                'label' => 'deal.form.label.startdate',
                'required' => false,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'translation_domain' => 'forms'
            ])
            ->add('endDate',DateType::class, [
                'label' => 'deal.form.label.enddate',
                'required' => false,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'translation_domain' => 'forms'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'deal.form.label.description',
                'translation_domain' => 'forms'
            ])
            ->add('costPoint', NumberType::class, [
                'label' => 'deal.form.label.costpoint',
                'translation_domain' => 'forms'
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Deal::class,
        ]);
    }
}
