<?php
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient([], [
            'PHP_AUTH_USER' => 'Silversat',
            'PHP_AUTH_PW' => 'Shafheux'
        ]);
    }

    public function testListUserPage()
    {
        $this->client->request('GET', '/users');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testListUserPageIfNotLogin()
    {
        $client = static::createClient([], []);
        $client->request('GET', '/users');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testCreateUserPage()
    {
        $this->client->request('GET', '/users/create');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateUserPageIfNotLogin()
    {
        $client = static::createClient([], []);
        $client->request('GET', '/users/create');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testEditUserIfExistPage()
    {
        $this->client->request('GET', '/users/3/edit');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testEditUserPageIfExistPageAndIfNotLogin()
    {
        $client = static::createClient([], []);
        $client->request('GET', '/users/4/edit');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testEditUserIfNotExistPage()
    {
        $this->client->request('GET', '/users/a/edit');

        $this->assertSame(404, $this->client->getResponse()->getStatusCode());
    }

    public function testEditUserPageIfNotExistPageAndIfNotLogin()
    {
        $client = static::createClient([], []);
        $client->request('GET', '/users/a/edit');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testCreateUserForm()
    {
        $crawler = $this->client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();

        $form['user[username]'] = 'Un nouveau nom';
        $form['user[password][first]'] = '12345';
        $form['user[password][second]'] = '12345';
        $form['user[email]'] = 'unemail@test.fr';
        $form['user[roles]'] = ["ROLE_USER"];

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success.flash-block')->count());
    }

    public function testEditUserForm()
    {
        $crawler = $this->client->request('GET', '/users/3/edit');

        $form = $crawler->selectButton('Modifier')->form();

        $form['edit_user[username]'] = 'Un nom modifié';
        $form['edit_user[password][first]'] = '54321';
        $form['edit_user[password][second]'] = '54321';
        $form['edit_user[email]'] = 'unemailmodifier@test.fr';
        $form['edit_user[roles]'] = ["ROLE_USER"];

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success.flash-block')->count());
    }
}