<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $user;

    private $reflection;

    public function setUp()
    {
        $this->user = new User();
        $this->reflection = new \ReflectionClass($this->user);
    }

    /* Test GETTER */

    public function testUserGetId()
    {
        $property = $this->reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($this->user, 5);

        $this->assertEquals(5, $this->user->getId());
    }

    public function testUserGetUsername()
    {
        $property = $this->reflection->getProperty('username');
        $property->setAccessible(true);
        $property->setValue($this->user, 'Un nom');

        $this->assertEquals('Un nom', $this->user->getUsername());
    }

    public function testUserGetEmail()
    {
        $property = $this->reflection->getProperty('email');
        $property->setAccessible(true);
        $property->setValue($this->user, 'unemail@email.fr');

        $this->assertEquals('unemail@email.fr', $this->user->getEmail());
    }

    public function testUserGetPassword()
    {
        $property = $this->reflection->getProperty('password');
        $property->setAccessible(true);
        $property->setValue($this->user, 'password');

        $this->assertEquals('password', $this->user->getPassword());
    }

    public function testUserGetRoles()
    {
        $property = $this->reflection->getProperty('roles');
        $property->setAccessible(true);
        $property->setValue($this->user, ['ROLE_USER']);

        $this->assertEquals(['ROLE_USER'], $this->user->getRoles());
    }

    /* Test SETTER */

    public function testUserSetUsername()
    {
        $this->assertEquals($this->user, $this->user->setUsername('Un nom'));
        $this->assertAttributeEquals('Un nom', 'username', $this->user);
    }

    public function testUserSetEmail()
    {
        $this->assertEquals($this->user, $this->user->setEmail('unemail@email.fr'));
        $this->assertAttributeEquals('unemail@email.fr', 'email', $this->user);
    }

    public function testUserSetPassword()
    {
        $this->assertEquals($this->user, $this->user->setPassword('test'));
        $this->assertAttributeEquals('test', 'password', $this->user);
    }

    public function testUserSetRoles()
    {
        $this->assertEquals($this->user, $this->user->setRoles(['ROLE_USER']));
        $this->assertAttributeEquals(['ROLE_USER'], 'roles', $this->user);
    }
}