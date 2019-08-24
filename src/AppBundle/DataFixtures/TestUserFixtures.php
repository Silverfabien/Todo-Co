<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
/**
 * Fixtures for tests launched by PhpUnit
 *
 * Class TestUserFixtures
 *
 * @category
 * @package  AppBundle\DataFixtures
 * @author   Fabien Hollebeque <hollebeque.fabien@hotmail.com>
 * @license
 * @link
 */
class TestUserFixtures extends Fixture
{
    const TEST_USER_REFERENCE = 'User';

    /**
     * Function that inserts data into a test database. See in the file app/config_test.yml
     *
     * @param ObjectManager $manager
     * @throws \Exception
     */
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