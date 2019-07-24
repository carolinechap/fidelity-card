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
        $centerCode = '123';
        $this->card->setCustomerCode($this->generateCustomerCode())
            ->setCheckSum(($this->card->getStore()->getCenterCode() + $this->card->getCustomerCode()) % 9);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function generateCustomerCodeTest()
    {
        $code = '456789';

        $findSameCustomerCodeTest = $this->entityManager
            ->getRepository('App\Entity\Card')
            ->findBy([
            'customerCode' => $code
        ]);

        if ($findSameCustomerCodeTest) {
            $this->generateCustomerCodeTest();
        }

        return sprintf("%06s",$code);
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