<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    private $task;

    private $reflection;

    public function setUp()
    {
        $this->task = new Task();
        $this->reflection = new \ReflectionClass($this->task);
    }

    public function testTaskIsDone()
    {
        $this->task->toggle(false);

        $this->assertEquals(false, $this->task->isDone());
    }

    /* Test GETTER */

    public function testTaskGetId()
    {
        $property = $this->reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($this->task, 5);

        $this->assertEquals(5, $this->task->getId());
    }

    public function testTaskGetTitle()
    {
        $property = $this->reflection->getProperty('title');
        $property->setAccessible(true);
        $property->setValue($this->task, 'Le titre de la tâche');

        $this->assertEquals('Le titre de la tâche', $this->task->getTitle());
    }

    public function testTaskGetContent()
    {
        $property = $this->reflection->getProperty('content');
        $property->setAccessible(true);
        $property->setValue($this->task, 'Le contenu de la tâche');

        $this->assertEquals('Le contenu de la tâche', $this->task->getContent());
    }

    public function testTaskGetCreatedAt()
    {
        $date = new \DateTime();

        $property = $this->reflection->getProperty('createdAt');
        $property->setAccessible(true);
        $property->setValue($this->task, $date);

        $this->assertEquals($date, $this->task->getCreatedAt());
    }

    public function testTaskGetUser()
    {
        $user = new User();

        $property = $this->reflection->getProperty('user');
        $property->setAccessible(true);
        $property->setValue($this->task, $user);

        $this->assertEquals($user, $this->task->getUser());
    }

    /* Test SETTER */

    public function testTaskSetTitle()
    {
        $this->assertEquals($this->task, $this->task->setTitle('Le titre de la tâche'));
        $this->assertAttributeEquals('Le titre de la tâche', 'title', $this->task);
    }

    public function testTaskSetContent()
    {
        $this->assertEquals($this->task, $this->task->setContent('Le contenu de la tâche'));
        $this->assertAttributeEquals('Le contenu de la tâche', 'content', $this->task);
    }

    public function testTaskSetCreatedAt()
    {
        $date = new \DateTime();

        $this->assertEquals($this->task, $this->task->setCreatedAt($date));
        $this->assertAttributeEquals($date, 'createdAt', $this->task);
    }

    public function testTaskSetUser()
    {
        $user = new User();

        $this->assertEquals($this->task, $this->task->setUser($user));
        $this->assertAttributeEquals($user, 'user', $this->task);
    }
}