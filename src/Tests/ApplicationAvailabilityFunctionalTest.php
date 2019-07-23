<?php


namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        yield ['/'];
        yield ['/dashboards/clients'];
        yield ['/dashboards/employes'];
        yield ['/dashboards/carte/activite'];
        yield ['/dashboards/carte'];
        yield ['/dashboard/store'];
        yield ['/dashboard/deal'];
        yield ['/dashboard/activity'];
        yield ['/archives'];
        // ...
    }


}