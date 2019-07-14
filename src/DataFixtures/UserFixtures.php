<?php
/**
 * Created by PhpStorm.
 * User: Corinne
 * Date: 14/07/2019
 * Time: 06:46
 */

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        //This superadmin is for test and demo purposes, login with email 'superadmin@email.com' and password superadmin
        $superAdmin = new User();
        $superAdmin->setFirstname("SuperAdmin");
        $superAdmin->setLastname("SuperAdmin");
        $superAdmin->setEmail('superadmin@email.com');

        $superAdmin->setPassword($this->encoder->encodePassword($superAdmin, 'superadmin'));

        $superAdmin->setNumberStreet($faker->buildingNumber);
        $superAdmin->setNameStreet($faker->streetName);
        $superAdmin->setZipCode($faker->postcode);
        $superAdmin->setCity($faker->city);
        $superAdmin->setCountry('France');
        $superAdmin->setRoles(['ROLE_SUPERADMIN']);

        $manager->persist($superAdmin);
        $this->addReference('superadmin', $superAdmin);

        //This admin is for test and demo purposes, login with email 'admin@email.com' and password admin
        $admin = new User();
        $admin->setFirstname("Admin");
        $admin->setLastname("Admin");
        $admin->setEmail('admin@email.com');

        $admin->setPassword($this->encoder->encodePassword($admin, 'admin'));

        $admin->setNumberStreet($faker->buildingNumber);
        $admin->setNameStreet($faker->streetName);
        $admin->setZipCode($faker->postcode);
        $admin->setCity($faker->city);
        $admin->setCountry('France');
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);
        $this->addReference('admin', $admin);

        $manager->flush();
    }
}