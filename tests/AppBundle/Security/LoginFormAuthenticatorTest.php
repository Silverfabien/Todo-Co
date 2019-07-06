<?php

namespace Tests\AppBundle\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginFormAuthenticatorTest extends WebTestCase
{
    public function testOnAuthenticationSuccess()
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $crawler = $client->getCrawler();
        $form = $crawler->filter('#submit-login')->form();
        $client->submit($form, [
            'login[username]'    => 'Silversat',
            'login[password]' => 'Shafheux',
        ]);

        $this->assertSame(302, $client->getResponse()->getStatusCode());

        $client->followRedirect();

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertSame('/', $client->getRequest()->getRequestUri());
    }

    public function testOnAuthenticationFailure()
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $crawler = $client->getCrawler();
        $form = $crawler->filter('#submit-login')->form();
        $client->submit($form, [
            'login[username]'    => 'Silversat',
            'login[password]' => 'MauvaisMotDePasse',
        ]);

        $this->assertSame(302, $client->getResponse()->getStatusCode());

        $client->followRedirect();

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertSame('/login', $client->getRequest()->getRequestUri());
    }
}