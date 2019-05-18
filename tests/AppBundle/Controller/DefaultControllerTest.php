<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndexPageIfNotLogin()
    {
        $client = static::createClient([], []);
        $client->request('GET', '/');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testIndexPageIfLogin()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'Silversat',
            'PHP_AUTH_PW' => 'Shafheux'
        ]);

        $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
}