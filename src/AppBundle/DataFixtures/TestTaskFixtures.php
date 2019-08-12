<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TestTaskFixtures extends Fixture
{
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