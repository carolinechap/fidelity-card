<?php


namespace App\Controller\Admin;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController
{
    public function codeCustomer()
    {
        $maxCustomerCode = $this->getDoctrine()
            ->getRepository(User::class)
            ->getLastCustomerCode();
        $customerCode = (int)$maxCustomerCode['lastCode'] +1;
        $user = new User();
        $user->setCustomerCode($customerCode);
        return $this;
    }
}