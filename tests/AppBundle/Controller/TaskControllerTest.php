<?php

namespace Tests\AppBundle\Controller;

use AppBundle\DataFixtures\TestTaskFixtures;
use AppBundle\DataFixtures\TestUserFixtures;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    use FixturesTrait;

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient([], [
                'PHP_AUTH_USER' => 'Admin',
                'PHP_AUTH_PW' => 'Password'
        ]);

        $this->loadFixtures([
            TestUserFixtures::class,
            TestTaskFixtures::class
            ]);
    }

    public function testCheckPermissionIsTrue()
    {
        $this->client->request('GET', '/tasks/1/edit');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testCheckPermissionIsFalse()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'User',
            'PHP_AUTH_PW' => 'Password'
        ]);

        $client->request('GET', '/tasks/1/edit');

        $this->assertSame(403, $client->getResponse()->getStatusCode());
    }

    /** TEST ROUTE IF LOGIN */

    public function testCreateTaskPage()
    {
        $this->client->request('GET', '/tasks/create');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testEditTaskPage()
    {
        $this->client->request('GET', '/tasks/1/edit');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteTaskPage()
    {
        $this->client->request('GET', '/tasks/2/delete');

        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    }

    public function testListTaskPage()
    {
        $this->client->request('GET', '/tasks');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testToggleTaskIfRealised()
    {
        $crawler = $this->client->request('GET', '/tasks/1/toggle');

        $crawler->selectButton('Marquer comme faite');
        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success.flash-block')->count());
    }

    public function testToggleTaskIfNotRealised()
    {
        $crawler = $this->client->request('GET', '/tasks/2/toggle');

        $crawler->selectButton('Marquer non terminée');
        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-warning.flash-block')->count());
    }

    public function testAjaxGetTask()
    {
        $this->client->request('GET', '/task');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }


    /** TEST ROUTE IF NOT LOGIN */

    public function testCreateTaskPageIfNotLogin()
    {
        $client = static::createClient([], []);
        $client->request('GET', '/tasks/create');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testEditTaskPageIfNotLogin()
    {
        $client = static::createClient([], []);
        $client->request('GET', '/tasks/1/edit');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testDeleteTaskPageIfNotLogin()
    {
        $client = static::createClient([], []);
        $client->request('GET', '/tasks/1/delete');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testListTaskPageIfNotLogin()
    {
        $client = static::createClient([], []);
        $client->request('GET', '/tasks');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testToggleTaskIfNotLogin()
    {
        $client = static::createClient([], []);
        $client->request('GET', '/tasks/1/toggle');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }


    /** TEST ROUTE IF NOT EXIST */

    public function testEditTaskIfNotExistPage()
    {
        $this->client->request('GET', '/tasks/a/edit');

        $this->assertSame(404, $this->client->getResponse()->getStatusCode());
    }

    public function testEditTaskIfNotExistAndIfNotLogin()
    {
        $client = static::createClient([], []);
        $client->request('GET', '/tasks/a/edit');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testDeleteTaskIfNotExistPage()
    {
        $this->client->request('GET', '/tasks/a/delete');

        $this->assertSame(404, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteTaskPageIfNotExistAndIfNotLogin()
    {
        $client = static::createClient([], []);
        $client->request('GET', '/tasks/a/delete');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testToggleTaskIfNotExist()
    {
        $this->client->request('GET', '/tasks/a/toggle');

        $this->assertSame(404, $this->client->getResponse()->getStatusCode());
    }

    public function testToggleTaskIfNotExistAndIfNotLogin()
    {
        $client = static::createClient([], []);
        $client->request('GET', '/tasks/a/toggle');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }


    /** TEST BUTTONS */

    public function testButtonCreateTaskOnTaskView()
    {
        $crawler = $this->client->request('GET', '/tasks');

        $link = $crawler->selectLink('Créer une tâche')->link();
        $crawler = $this->client->click($link);

        $this->assertSame(1, $crawler->count());
    }

    public function testButtonCreateTaskOnIndex()
    {
        $crawler = $this->client->request('GET', '/');

        $link = $crawler->selectLink('Créer une nouvelle tâche')->link();
        $crawler = $this->client->click($link);

        $this->assertSame(1, $crawler->count());
    }

    public function testButtonTaskList()
    {
        $crawler = $this->client->request('GET', '/');

        $link = $crawler->selectLink('Consulter la liste des tâches')->link();
        $crawler = $this->client->click($link);

        $this->assertSame(1, $crawler->count());
    }


    /** TEST FORM */

    public function testAddTaskForm()
    {
        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Le titre du test';
        $form['task[content]'] = 'Le contenu du test';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success.flash-block')->count());
    }

    public function testEditTaskForm()
    {
        $crawler = $this->client->request('GET', '/tasks/1/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Le titre modifier du test';
        $form['task[content]'] = 'Le contenu modifier du test';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success.flash-block')->count());
    }
}