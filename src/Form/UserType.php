<?php

namespace App\Form;

use App\Entity\User;
use App\User\UserRequest;
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
            [
                'translation_domain' => 'forms',
                'label' => 'user.form.label.lastname',
            ]
            )
            ->add('firstname',
                TextType::class,
                [
                    'translation_domain' => 'forms',
                    'label' => 'user.form.label.firstname',
                ]            )
            ->add('email',
                EmailType::class,
                [
                    'translation_domain' => 'forms',
                    'label' => 'user.form.label.email',
                ]
            )
            ->add('plainPassword',
                RepeatedType::class,
                ['type' => PasswordType::class,
                    'first_options' => [
                        'translation_domain' => 'forms',
                        'label' => 'user.form.label.password',
                    ],
                    'second_options' => [
                        'translation_domain' => 'forms',
                        'label' => 'user.form.label.confirmation_password',
                    ],
                    'invalid_message' => 'La confirmation doit correspondre au mot de passe'
                    ]
            )
            ->add('numberStreet',
                TextType::class,
                [
                    'translation_domain' => 'forms',
                    'label' => 'user.form.label.number_street',
                    'required' => false
                    ]
                )
            ->add('nameStreet',
                TextType::class,
                [
                    'translation_domain' => 'forms',
                    'label' => 'user.form.label.name_street',
                    'required' => false
                ]
            )
            ->add('zipCode',
                TextType::class,
                [
                    'translation_domain' => 'forms',
                    'label' => 'user.form.label.zip_code',
                    'required' => false
                ]
            )
            ->add('city',
                TextType::class,
                [
                    'translation_domain' => 'forms',
                    'label' => 'user.form.label.city',
                    'required' => false
                ]
            )
            ->add('country',
                TextType::class,
                [
                    'translation_domain' => 'forms',
                    'label' => 'user.form.label.country',
                    'required' => false
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserRequest::class,
        ]);
    }
}
