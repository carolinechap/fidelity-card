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
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

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
                ])
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
            );

        if (!$this->security->isGranted(['ROLE_SUPERADMIN'])) {
            $builder
                ->add('numberStreet',
                    TextType::class,
                    [
                        'translation_domain' => 'forms',
                        'label' => 'user.form.label.number_street',
                        'required' => true,
                        'constraints' => [
                            new NotBlank(),
                        ]
                    ]
                )
                ->add('nameStreet',
                    TextType::class,
                    [
                        'translation_domain' => 'forms',
                        'label' => 'user.form.label.name_street',
                        'required' => true,
                        'constraints' => [
                            new NotBlank(),
                        ]
                    ]
                )
                ->add('zipCode',
                    TextType::class,
                    [
                        'translation_domain' => 'forms',
                        'label' => 'user.form.label.zip_code',
                        'required' => true,
                        'constraints' => [
                            new NotBlank(),
                        ]
                    ]
                )
                ->add('city',
                    TextType::class,
                    [
                        'translation_domain' => 'forms',
                        'label' => 'user.form.label.city',
                        'required' => true,
                        'constraints' => [
                            new NotBlank(),
                        ]
                    ]
                )
                ->add('country',
                    TextType::class,
                    [
                        'translation_domain' => 'forms',
                        'label' => 'user.form.label.country',
                        'required' => true,
                        'constraints' => [
                            new NotBlank(),
                        ]
                    ]
                );
        } else {
            $builder
                ->add('numberStreet',
                    TextType::class,
                    [
                        'translation_domain' => 'forms',
                        'label' => 'user.form.label.number_street',
                        'required' => false,
                    ]
                )
                ->add('nameStreet',
                    TextType::class,
                    [
                        'translation_domain' => 'forms',
                        'label' => 'user.form.label.name_street',
                        'required' => false,
                    ]
                )
                ->add('zipCode',
                    TextType::class,
                    [
                        'translation_domain' => 'forms',
                        'label' => 'user.form.label.zip_code',
                        'required' => false,
                    ]
                )
                ->add('city',
                    TextType::class,
                    [
                        'translation_domain' => 'forms',
                        'label' => 'user.form.label.city',
                        'required' => false,
                    ]
                )
                ->add('country',
                    TextType::class,
                    [
                        'translation_domain' => 'forms',
                        'label' => 'user.form.label.country',
                        'required' => false,
                    ]
                );
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public
    function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserRequest::class,
        ]);
    }
}
