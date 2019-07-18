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

/**
 * Class AddCardType
 * @package App\Form
 */
class AddCardType extends AbstractType
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * AddCardType constructor.
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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
                        'max' => 12])
                ],
                'translation_domain' => 'forms',
                //'label' => 'card.add.user.label'
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
    }

}