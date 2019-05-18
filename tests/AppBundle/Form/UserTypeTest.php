<?php

namespace Tests\AppBundle\Form;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends TypeTestCase
{
    public function testFormUser()
    {
        $test = $this->createMock(User::class);

        $formData = [
            'username' => 'Un nom',
            'password' => ['first_options' => 'test', 'second_options' => 'test'],
            'email' => 'unemail@email.fr',
            'role' => ['ROLE_USER']
        ];

        $userToCompare = $test;

        $form = $this->factory->create(UserType::class, $userToCompare);

        $user = $test;
        $user->setUsername('Un nom');
        $user->setPassword('test');
        $user->setEmail('unemail@email.fr');
        $user->setRoles(['ROLE_USER']);
        $form->submit($formData);

        $this->assertTrue($form->isValid());
        $this->assertEquals($user, $userToCompare);
        $this->assertInstanceOf(User::class, $form->getData());
    }
}