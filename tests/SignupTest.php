<?php


namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SignupTest extends WebTestCase
{

    /** @test */
    public function signup()
    {

        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        // Check the status of the home page
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Click on the link
        $link = $crawler->filter('a.btn-dark')->link();
        $crawler = $client->click($link);

        // Form
        $form = $crawler->selectButton('Enregistrer')->form();

        // Set values
        $form['user[firstname]'] = 'Caroline';
        $form['user[lastname]'] = 'Chapeau';
        $form['user[email]'] = 'caroline2chapeau@gmail.com';
        $form['user[plainPassword][first]'] = 'caroline';
        $form['user[plainPassword][second]'] = 'caroline';
        $form['user[numberStreet]'] = '2';
        $form['user[nameStreet]'] = 'Rue du dev';
        $form['user[zipCode]'] = '69009';
        $form['user[city]'] = 'Lyon';
        $form['user[country]'] = 'France';

        // Submit signup form
        $client->submit($form);

        // Follow the redirection to login
        $crawler = $client->followRedirect();
        dump($crawler);



        // Check if the signup form submit successfully
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());

        // Check the status of the login page
        $crawler = $client->request('GET', '/connexion');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        //Sign in
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'caroline2chapeau@gmail.com' ;
        $form['_password'] = 'caroline';
        $client->submit($form);


    }
}