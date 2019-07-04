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

    const COUNT = 100;


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

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
            //TODO:Ajouter le Customer Code
            //$customer->setCustomerCode()

            $manager->persist($customer);
        }

        $manager->flush();

    }


}
