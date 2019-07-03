<?php


namespace App\User;


use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFactory
{
    private $encoder;

    /**
     * UserFactory constructor.
     * @param PasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;

    }

    /**
     * @param UserRequest $userRequest
     * @return User
     */
    public function createFromUserRequest(UserRequest $userRequest): User
    {

        $user = new User();

        $user->setFirstname($userRequest->getFirstname());
        $user->setLastname($userRequest->getLastname());
        $user->setEmail($userRequest->getEmail());
        $user->setPassword($this->encoder->encodePassword($user, $userRequest->getPlainPassword()));

        $user->setNumberStreet($userRequest->getNumberStreet());
        $user->setNameStreet($userRequest->getNameStreet());
        $user->setCity($userRequest->getCity());
        $user->setZipCode($userRequest->getZipCode());
        $user->setCountry($userRequest->getCountry());

        //TODO: Ajouter le CustomerCode


        return $user;
    }
}