<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class EmployeeFixtures
 * @package App\DataFixtures
 */
class EmployeeFixtures extends Fixture
{

    const NB_ADMINS = 10;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * EmployeeFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');


        //This superadmin is for test and demo purposes, login with email 'superadmin@email.com' and password superadmin
        $superAdmin = new User();

        $superAdmin->setFirstname("Superadmin");
        $superAdmin->setLastname("Superadmin");
        $superAdmin->setEmail('superadmin@email.com');

        $superAdmin->setNumberStreet($faker->buildingNumber);
        $superAdmin->setNameStreet($faker->streetName);
        $superAdmin->setZipCode($faker->postcode);
        $superAdmin->setCity($faker->city);
        $superAdmin->setCountry('France');
        $superAdmin->setRoles(['ROLE_SUPERADMIN']);

        $superAdmin->setPlainPassword("superadmin");
        $passwordAdmin = $this->encoder->encodePassword(
            $superAdmin,
            $superAdmin->getPlainPassword()
        );
        $superAdmin->setPassword($passwordAdmin);

        $manager->persist($superAdmin);




        //Store admins for demo/test and dev fixtures
        for ($i = 0; $i < self::NB_ADMINS; $i ++) {
            $admin = new User();
            $admin->setFirstname("Admin-" .$i);
            $admin->setLastname("Admin-" .$i);
            $admin->setEmail('admin'. $i.'@email.com');

            $admin->setNumberStreet($faker->buildingNumber);
            $admin->setNameStreet($faker->streetName);
            $admin->setZipCode($faker->postcode);
            $admin->setCity($faker->city);
            $admin->setCountry('France');
            $admin->setRoles(['ROLE_ADMIN']);

            $admin->setPlainPassword("admin" .$i);
            $passwordAdmin = $this->encoder->encodePassword(
                $admin,
                $admin->getPlainPassword()
            );
            $admin->setPassword($passwordAdmin);

            $this->addReference('admin_'.$i, $admin);

            $manager->persist($admin);
        }
        $manager->flush();
    }
}
