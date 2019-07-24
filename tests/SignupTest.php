<?php


namespace App\Tests;


use Faker\Factory;
use Faker\Provider\fr_FR\Person;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SignupTest extends WebTestCase
{

    /** @test */
    public function signup()
    {

        $faker = Factory::create('fr_FR');

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
        $fistname = $faker->firstName;
        $lastname = $faker->lastName;

        $mail = strtolower($lastname) . '.' . strtolower($fistname) . '@email.com';


        $form['user[firstname]'] = $fistname;
        $form['user[lastname]'] = $lastname;
        $form['user[email]'] = $mail;
        $form['user[plainPassword][first]'] = 'test123';
        $form['user[plainPassword][second]'] = 'test123';
        $form['user[numberStreet]'] = '2';
        $form['user[nameStreet]'] = 'Rue du dev';
        $form['user[zipCode]'] = '69009';
        $form['user[city]'] = 'Lyon';
        $form['user[country]'] = 'France';

        // Submit signup form
        $client->submit($form);

        // Follow the redirection to login
        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();


        // Check the redirection and the status of the login page
        $crawler = $client->request('GET', '/connexion');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        //Sign in
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = $mail ;
        $form['_password'] = 'test123';
        $client->submit($form);

    }
}