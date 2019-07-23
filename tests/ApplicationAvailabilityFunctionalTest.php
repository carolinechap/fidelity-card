<?php


namespace App\tests;




use Symfony\Component\Panther\PantherTestCase;

class ApplicationAvailabilityFunctionalTest extends PantherTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = static::createPantherClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * @return array
     */
    public function urlProvider()
    {
        return [
            ['/'],
            ['/dashboards/clients'],
            ['/dashboards/employes'],
            ['/dashboards/carte/activite'],
            ['/dashboards/carte'],
            ['/dashboard/store'],
            ['/dashboard/deal'],
            ['/dashboard/activity'],
        ];

    }


}