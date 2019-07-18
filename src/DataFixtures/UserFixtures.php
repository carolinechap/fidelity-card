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
    const NB_ADMINS = 10;

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
        $superadmin = new User();

        $superadmin->setFirstname("Superadmin");
        $superadmin->setLastname("Superadmin");
        $superadmin->setEmail('superadmin@email.com');

        $superadmin->setNumberStreet($faker->buildingNumber);
        $superadmin->setNameStreet($faker->streetName);
        $superadmin->setZipCode($faker->postcode);
        $superadmin->setCity($faker->city);
        $superadmin->setCountry('France');
        $superadmin->setRoles(['ROLE_SUPERADMIN']);

        $superadmin->setPlainPassword("superadmin");
        $passwordAdmin = $this->encoder->encodePassword(
            $superadmin,
            $superadmin->getPlainPassword()
        );
        $superadmin->setPassword($passwordAdmin);

        $manager->persist($superadmin);

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