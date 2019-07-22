<?php
/**
 * Created by PhpStorm.
 * User: Corinne
 * Date: 14/07/2019
 * Time: 17:47
 */

namespace App\Validator\Constraints;

use App\Repository\CardRepository;
use App\Repository\StoreRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Security\Core\Security;
use App\Card\CardNumberExtractor;

/**
 * Class IsValidCardNumberValidator
 * @package App\Validator\Constraints
 */
class IsValidCardNumberValidator extends ConstraintValidator
{

    /**
     * @var CardRepository
     */
    private $cardRepository;

    /**
     * @var StoreRepository
     */
    private $storeRepository;

    /**
     * @var Security
     */
    private $security;

    /**
     * @var CardNumberExtractor
     */
    private $cardNumberExtractor;


    /**
     * IsValidCardNumberValidator constructor.
     * @param CardRepository $cardRepository
     * @param StoreRepository $storeRepository
     * @param Security $security
     * @param CardNumberExtractor $cardNumberExtractor
     */
    public function __construct(CardRepository $cardRepository,
                                StoreRepository $storeRepository,
                                Security $security,
                                CardNumberExtractor $cardNumberExtractor)
    {
        $this->cardRepository = $cardRepository;
        $this->storeRepository = $storeRepository;
        $this->security = $security;
        $this->cardNumberExtractor = $cardNumberExtractor;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof IsValidCardNumber) {
            throw new UnexpectedTypeException($constraint, IsValidCardNumber::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'string');
        }

        if (!preg_match('/^([0-9 \-]+)$/', $value, $matches)) {
            $this->context->buildViolation('card.number.not_match_regex')
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }

        $customerCode = $this->cardNumberExtractor->evaluate($value)['code_carte'];
        $codeCentre = $this->cardNumberExtractor->evaluate($value)['code_centre'];
        $checkSum = $this->cardNumberExtractor->evaluate($value)['checksum'];
        if (
                (strlen($codeCentre) !== 3) || (strlen($customerCode)) !== 6 ||
                (!$this->storeRepository->findOneBy(['centerCode' => $codeCentre])) ||
                (!$this->cardRepository->findOneBy(['customerCode' => $customerCode])) ||
                $checkSum !== ((intval($codeCentre) + intval($customerCode))% 9)
        )
            {
                $this->context->buildViolation('card.number.not_valid')
                    ->setParameter('{{ string }}', $value)
                    ->addViolation();
            }
    }

}