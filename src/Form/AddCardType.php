<?php
/**
 * Created by PhpStorm.
 * User: Corinne
 * Date: 14/07/2019
 * Time: 17:38
 */

namespace App\Form;

use App\Validator\Constraints\IsValidCardNumber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;

class AddCardType extends AbstractType
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->setAction($this->urlGenerator->generate('card_add_user'))
            ->add('card_number', TextType::class, [
                'attr' => [
                    'placeholder' => 'XXX-XXXXXX-X'
                ],
                'required' => true,
                'constraints' => [
                        new NotBlank(),
                        new NotNull(),
                        new IsValidCardNumber(),
                        new Length(['min' => 10,
                            'minMessage' => 'card.number.too_short',
                            'max' => 12,
                            'maxMessage' => 'card.number.too_long'])
                ],
                'translation_domain' => 'forms',
                'label' => 'card.add.user.label'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }

}