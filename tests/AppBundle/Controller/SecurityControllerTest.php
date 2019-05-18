<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Controller\SecurityController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient([], [
            'PHP_AUTH_USER' => 'Silversat',
            'PHP_AUTH_PW' => 'Shafheux'
        ]);
    }

    public function testLoginPage()
    {
        $this->client->request('GET', '/login');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testLogoutPage()
    {
        $this->client->request('GET', '/logout');

        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    }

    public function testLoginCheck()
    {
        $this->expectException(\Exception::class);
        $controller = new SecurityController();
        $controller->loginCheck();
    }

    public function testLogout()
    {
        $this->expectException(\Exception::class);
        $controller = new SecurityController();
        $controller->logout();
    }
}