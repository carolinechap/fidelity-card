<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class AddCardToCustomerTest extends WebTestCase
{
    public function testHomePage()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function connectAdmin($crawler)
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/post/hello-world');

        $link = $client->clickLink('Se connecter');

        // and click it
        $client->click($link);
    }

}