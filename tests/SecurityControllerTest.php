<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testSomething()
    {
        $client = static::createClient();

        //testing wrong email case
        $crawler = $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Please sign in');
        $this->assertPageTitleContains('Log in!');
        $button = $crawler->selectButton('Sign in');
        $form = $button->form();
        $client->submit($form, [
            'email' => 'adminwrong@admin.org',
            'password' => 'admin'
        ]);
        $crawler  = $client->followRedirect();
        $this->assertSelectorTextContains('.alert', 'Email could not be found.');


        //testing wrong password case
        $crawler = $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
        $button = $crawler->selectButton('Sign in');
        $form = $button->form();
        $client->submit($form, [
            'email' => 'admin@admin.org',
            'password' => 'adminwrong'
        ]);
        $crawler  = $client->followRedirect();
        $this->assertSelectorTextContains('.alert', 'Invalid credentials.');

        //testing all well case
        $crawler = $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
        $button = $crawler->selectButton('Sign in');
        $form = $button->form();
        $client->submit($form, [
            'email' => 'admin@admin.org',
            'password' => 'admin'
        ]);
        $crawler  = $client->followRedirect();
        $this->assertSelectorTextContains('h4', 'Hi');
    }
}
