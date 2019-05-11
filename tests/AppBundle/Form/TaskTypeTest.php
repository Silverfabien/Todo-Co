<?php

namespace Tests\AppBundle\Form;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskTypeTest extends TypeTestCase
{
    public function testFormTask()
    {
        $test = $this->createMock(Task::class);

        $formData = [
            'title' => 'Un titre',
            'content' => 'Un contenu'
        ];

        $taskToCompare = $test;

        $form = $this->factory->create(TaskType::class, $taskToCompare);

        $task = $test;
        $task->setTitle('Un titre');
        $task->setContent('Un contenu');
        $form->submit($formData);

        $this->assertTrue($form->isValid());
        $this->assertEquals($task, $taskToCompare);
        $this->assertInstanceOf(Task::class, $form->getData());
    }
}