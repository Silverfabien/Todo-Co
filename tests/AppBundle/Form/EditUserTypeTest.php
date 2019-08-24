<?php

namespace Tests\AppBundle\Form;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Component\Form\Test\TypeTestCase;

class EditUserTypeTest extends TypeTestCase
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

        $userEditToCompare = $test;

        $form = $this->factory->create(UserType::class, $userEditToCompare);

        $userEdit = $test;
        $userEdit->setUsername('Un nom');
        $userEdit->setPassword('test');
        $userEdit->setEmail('unemail@email.fr');
        $userEdit->setRoles(['ROLE_USER']);
        $form->submit($formData);

        $this->assertTrue($form->isValid());
        $this->assertEquals($userEdit, $userEditToCompare);
        $this->assertInstanceOf(User::class, $form->getData());
    }
}