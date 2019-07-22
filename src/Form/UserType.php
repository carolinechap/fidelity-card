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
use Symfony\Component\Security\Core\Security;

/**
 * Class UserType
 * @package App\Form
 */
class UserType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $required = true;

        if($this->security->isGranted(['ROLE_SUPERADMIN'])){

            $required = false;
        }

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
                    'required' => $required
                    ]
                )
            ->add('nameStreet',
                TextType::class,
                [
                    'translation_domain' => 'forms',
                    'label' => 'user.form.label.name_street',
                    'required' => $required
                ]
            )
            ->add('zipCode',
                TextType::class,
                [
                    'translation_domain' => 'forms',
                    'label' => 'user.form.label.zip_code',
                    'required' => $required
                ]
            )
            ->add('city',
                TextType::class,
                [
                    'translation_domain' => 'forms',
                    'label' => 'user.form.label.city',
                    'required' => $required
                ]
            )
            ->add('country',
                TextType::class,
                [
                    'translation_domain' => 'forms',
                    'label' => 'user.form.label.country',
                    'required' => $required
                ]
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserRequest::class,
        ]);
    }
}
