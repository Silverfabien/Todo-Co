<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TestUserFixtures extends Fixture
{
    const TEST_USER_REFERENCE = 'User';

    public function load(ObjectManager $manager)
    {
        $testUserData = [
            [
                'Admin',
                '$2y$13$cuF.d8iVBIENiTKv4mCS2eKTzzZHe4ZSuUbRDaa2lRlBsJCv6Vza6',
                'admin@hotmail.com',
                ["ROLE_ADMIN"]
            ],
            [
                'User',
                '$2y$13$cuF.d8iVBIENiTKv4mCS2eKTzzZHe4ZSuUbRDaa2lRlBsJCv6Vza6',
                'user@hotmail.com',
                ["ROLE_USER"]
            ],
            [
                'test',
                '$2y$13$cuF.d8iVBIENiTKv4mCS2eKTzzZHe4ZSuUbRDaa2lRlBsJCv6Vza6',
                'test@hotmail.com',
                ["ROLE_USER"]
            ]
        ];

        $i = 0;

        foreach ($testUserData as list($username, $password, $email, $roles)) {
            $user = new User();
            $user->setUsername($username);
            $user->setPassword($password);
            $user->setEmail($email);
            $user->setRoles($roles);

            $manager->persist($user);
            $manager->flush();

            $this->addReference(self::TEST_USER_REFERENCE . $i, $user);
            $i++;
        }
    }
}