<?php


namespace App\Tests\Card;

use App\Entity\Card;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\Persistence\ObjectRepository;

class CardGeneratorTest extends WebTestCase
{

    /**
     * @test
     */
    public function generateCustomerCodeTest()
    {
        $card = new Card();
        $code = '456789';

        $card->setCustomerCode($code);

        $cardRepository = $this->createMock(ObjectRepository::class);

        $cardRepository->expects($this->any())
            ->method('find')
            ->willReturn($card);

        $objectManager = $this->createMock(ObjectManager::class);

        $objectManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($cardRepository);

        $this->assertEquals('456789', $card->getCustomerCode());
    }

}