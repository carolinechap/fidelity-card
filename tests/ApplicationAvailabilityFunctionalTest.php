<?php


namespace App\Tests;


use Symfony\Component\Panther\PantherTestCase;

class ApplicationAvailabilityFunctionalTest extends PantherTestCase
{

    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', $url);

        switch ($crawler) {
            case $crawler = $client->request('GET', '/' ):
                $this->assertContains('Classement', $crawler->filter('h1')->text());
                break;
            case $crawler = $client->request('GET', '/dashboards/clients'):
                $this->assertContains('Liste des clients', $crawler->filter('h1')->text());
                break;
            case $crawler = $client->request('GET', '/dashboards/employes' ):
                $this->assertContains('Liste des employés', $crawler->filter('h1')->text());
                break;
            case $crawler = $client->request('GET', '/dashboards/carte/activite' ):
                $this->assertContains('Activités Client', $crawler->filter('h1')->text());
                break;
            case $crawler = $client->request('GET', '/dashboards/carte' ):
                $this->assertContains('Cartes de fidélités', $crawler->filter('h1')->text());
                break;
            case $crawler = $client->request('GET', '/dashboard/store' ):
                $this->assertContains('Centres', $crawler->filter('h1')->text());
                break;
            case $crawler = $client->request('GET', '/dashboard/deal' ):
                $this->assertContains('Offres commerciales', $crawler->filter('h1')->text());
                break;
            case $crawler = $client->request('GET', '/dashboard/activity' ):
                $this->assertContains('Activités du laser game', $crawler->filter('h1')->text());
                break;
        }
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