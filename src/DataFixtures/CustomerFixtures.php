<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerFixtures extends Fixture
{
    private $encoder;

    const COUNT = 50;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        //This customer is for test and demo purposes, login with email 'customer@email.com' and password customer
        $oneCustomer = new User();
        $oneCustomer->setFirstname("Customer");
        $oneCustomer->setLastname("Customer");
        $oneCustomer->setEmail('customer@email.com');

        $oneCustomer->setPassword($this->encoder->encodePassword($oneCustomer, 'customer'));

        $oneCustomer->setNumberStreet($faker->buildingNumber);
        $oneCustomer->setNameStreet($faker->streetName);
        $oneCustomer->setZipCode($faker->postcode);
        $oneCustomer->setCity($faker->city);
        $oneCustomer->setCountry('France');
        $oneCustomer->setRoles(['ROLE_USER']);

        $manager->persist($oneCustomer);
        $this->addReference('mycustomer', $oneCustomer);
        //end of customer demo

        for($c = 0; $c<self::COUNT; $c++){
            $customer = new User();
            $customer->setFirstname($faker->firstName);
            $customer->setLastname($faker->lastName);
            $customer->setEmail($faker->email);

            $customer->setPassword($this->encoder->encodePassword($customer, $faker->password));

            $customer->setNumberStreet($faker->buildingNumber);
            $customer->setNameStreet($faker->streetName);
            $customer->setZipCode($faker->postcode);
            $customer->setCity($faker->city);
            $customer->setCountry('France');
            $customer->setRoles(['ROLE_USER']);

            $manager->persist($customer);
            $this->addReference('customer_'.$c, $customer);
        }

        $manager->flush();
    }
}
