<?php


namespace App\User;


use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class UserRequestHandler
 * @package App\User
 */
class UserRequestHandler
{
    /**
     * @var ObjectManager
     */
    private $objectManager;
    /**
     * @var UserFactory
     */
    private $userFactory;

    /**
     * UserRequestHandler constructor.
     * @param ObjectManager $objectManager
     * @param UserFactory $userFactory
     */
    public function __construct(ObjectManager $objectManager, UserFactory $userFactory)
    {
        $this->objectManager = $objectManager;
        $this->userFactory = $userFactory;
    }

    /**
     * @param UserRequest $userRequest
     * @return User
     */
    public function registerAsUser(UserRequest $userRequest): User
    {
        $user =  $this->userFactory->createFromUserRequest($userRequest);
        $user->addRole('ROLE_USER');

        $this->objectManager->persist($user);
        $this->objectManager->flush();

        return $user;
    }

    /**
     * @param UserRequest $userRequest
     * @return User
     */
    public function registerAsAdmin(UserRequest $userRequest) : User
    {
        $user =  $this->userFactory->createFromUserRequest($userRequest);
        $user->addRole('ROLE_ADMIN');

        $this->objectManager->persist($user);
        $this->objectManager->flush();

        return $user;

    }

}