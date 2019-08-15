<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Fixtures for tests launched by PhpUnit
 *
 * Class TestTaskFixtures
 *
 * @category
 * @package  AppBundle\DataFixtures
 * @author   Fabien Hollebeque <hollebeque.fabien@hotmail.com>
 * @license
 * @link
 */
class TestTaskFixtures extends Fixture
{
    /**
     * Function that inserts data into a test database. See in the file app/config_test.yml
     *
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $testTaskData = [
            [
                $this->getReference(TestUserFixtures::TEST_USER_REFERENCE . '0'),
                new \DateTime,
                'Un test',
                'Un contenu',
                false
            ],
            [
                $this->getReference(TestUserFixtures::TEST_USER_REFERENCE . '0'),
                new \DateTime,
                'Un test',
                'Un contenu',
                true
            ],
            [
                $this->getReference(TestUserFixtures::TEST_USER_REFERENCE . '0'),
                new \DateTime,
                'Un test',
                'Un contenu',
                false
            ],
            [
                $this->getReference(TestUserFixtures::TEST_USER_REFERENCE . '0'),
                new \DateTime,
                'Un test',
                'Un contenu',
                false
            ],
            [
                $this->getReference(TestUserFixtures::TEST_USER_REFERENCE . '0'),
                new \DateTime,
                'Un test',
                'Un contenu',
                false
            ],
            [
                $this->getReference(TestUserFixtures::TEST_USER_REFERENCE . '0'),
                new \DateTime,
                'Un test',
                'Un contenu',
                false
            ],
            [
                $this->getReference(TestUserFixtures::TEST_USER_REFERENCE . '0'),
                new \DateTime,
                'Un test',
                'Un contenu',
                false
            ],
            [
                $this->getReference(TestUserFixtures::TEST_USER_REFERENCE . '1'),
                new \DateTime,
                'Un test',
                'Un contenu',
                false
            ],
        ];

        foreach ($testTaskData as list($userId, $createdAt, $title, $content, $isDone)) {
            $task = new Task();
            $task->setUser($userId);
            $task->setCreatedAt($createdAt);
            $task->setTitle($title);
            $task->setContent($content);
            $task->setIsDone($isDone);

            $manager->persist($task);
            $manager->flush();
        }
    }
}