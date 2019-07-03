<?php


namespace App\User;


use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class UserRequestHandler
{
    private $objectManager;
    private $userFactory;

    public function __construct(ObjectManager $objectManager, UserFactory $userFactory)
    {
        $this->objectManager = $objectManager;
        $this->userFactory = $userFactory;
    }

    public function registerAsUser(UserRequest $userRequest): User
    {
        $user =  $this->userFactory->createFromUserRequest($userRequest);
        $user->addRole('ROLE_USER');

        $this->objectManager->persist($user);
        $this->objectManager->flush();

        return $user;
    }

    public function registerAsAdmin(UserRequest $userRequest) : User
    {
        $user =  $this->userFactory->createFromUserRequest($userRequest);
        $user->addRole('ROLE_ADMIN');

        $this->objectManager->persist($user);
        $this->objectManager->flush();

        return $user;

    }

}