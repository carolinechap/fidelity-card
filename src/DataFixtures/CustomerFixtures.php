<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Events\UserAccountEvent;
use App\Events\AppEvents;

/**
 * Class CustomerFixtures
 * @package App\DataFixtures
 */
class CustomerFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    private $eventDispatcher;

    const COUNT = 50;

    /**
     * CustomerFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder,
                                EventDispatcherInterface $eventDispatcher)
    {
        $this->encoder = $passwordEncoder;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        //This customer is for test and demo purposes, login with email 'customer@email.com' and password customer
        $oneCustomer = new User();
        $oneCustomer->setFirstname("Customer1");
        $oneCustomer->setLastname("Customer1");
        $oneCustomer->setEmail('customer1@email.com');

        $oneCustomer->setPassword($this->encoder->encodePassword($oneCustomer, 'customer1'));

        $oneCustomer->setNumberStreet($faker->buildingNumber);
        $oneCustomer->setNameStreet($faker->streetName);
        $oneCustomer->setZipCode($faker->postcode);
        $oneCustomer->setCity($faker->city);
        $oneCustomer->setCountry('France');
        $oneCustomer->setRoles(['ROLE_USER']);

        $manager->persist($oneCustomer);
        $this->addReference('customer1', $oneCustomer);

        //This customer is for test and demo purposes, login with email 'customer@email.com' and password customer
        $secondCustomer = new User();
        $secondCustomer->setFirstname("Customer2");
        $secondCustomer->setLastname("Customer2");
        $secondCustomer->setEmail('customer2@email.com');

        $secondCustomer->setPassword($this->encoder->encodePassword($secondCustomer, 'customer2'));

        $secondCustomer->setNumberStreet($faker->buildingNumber);
        $secondCustomer->setNameStreet($faker->streetName);
        $secondCustomer->setZipCode($faker->postcode);
        $secondCustomer->setCity($faker->city);
        $secondCustomer->setCountry('France');
        $secondCustomer->setRoles(['ROLE_USER']);

        $manager->persist($secondCustomer);
        $this->addReference('customer2', $secondCustomer);
        //end of customer demo

        for($c = 0; $c<self::COUNT; $c++){
            $customer = new User();
            $fakerFirstName = $faker->firstName;
            $customer->setFirstname($fakerFirstName);
            $customer->setLastname($faker->lastName);
            $customer->setEmail($fakerFirstName.'@email.com');

            $customer->setPassword($this->encoder->encodePassword($customer, $fakerFirstName));

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
