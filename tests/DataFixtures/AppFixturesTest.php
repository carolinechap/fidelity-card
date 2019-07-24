<?php


namespace App\Tests\DataFixtures;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;

use App\DataFixtures\ActivityFixtures;
use App\DataFixtures\CardFixtures;
use App\DataFixtures\CustomerFixtures;
use App\DataFixtures\DealFixtures;
use App\DataFixtures\EmployeeFixtures;
use App\DataFixtures\StoreFixtures;

class AppFixturesTest
{
    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;

        $loader = new Loader();
        $loader->addFixture(new ActivityFixtures());

        $purger = new ORMPurger($this->em);
        $executor = new ORMExecutor($this->em, $purger);
        $executor->execute($loader->getFixtures());

        parent::setUp();
    }

}