<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EmployeeFixture extends Fixture
{
    private $encoder;

    const COUNT = 10;


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($c = 0; $c<self::COUNT; $c++){
            $employee = new User();
            $employee->setFirstname($faker->firstName);
            $employee->setLastname($faker->lastName);
            $employee->setEmail($faker->email);

            $employee->setPassword($this->encoder->encodePassword($employee, $faker->password));


            $employee->setRoles(['ROLE_ADMIN']);

            $manager->persist($employee);
        }
        $manager->flush();
    }
}
