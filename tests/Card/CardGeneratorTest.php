<?php


namespace App\Tests\Card;

use App\Entity\Card;
use Doctrine\Common\Persistence\ObjectManager;use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\Persistence\ObjectRepository;

class CardGeneratorTest extends WebTestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(ObjectManager $objectManager, $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->objectManager = $objectManager;
    }

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->card = new Card();
        $centerCode = '123';
        $this->card->setCustomerCode($this->generateCustomerCodeTest())
            ->setCheckSum((intval($centerCode) + intval($this->generateCustomerCodeTest())) % 9);

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