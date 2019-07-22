<?php


namespace App\Tests\Card;

use App\Entity\Card;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class CardGeneratorTest extends KernelTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->card = new Card();
    }

    public function generateCustomerCodeTest()
    {
        $code = '123';

        $findSameCustomerCodeTest = $this->entityManager
            ->getRepository('App\Entity\Card')
            ->findBy([
            'customerCode' => $code
        ]);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }


}