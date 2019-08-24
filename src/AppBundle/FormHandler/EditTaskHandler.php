<?php

namespace AppBundle\FormHandler;

use AppBundle\Entity\Task;
use AppBundle\Repository\TaskRepository;
use Symfony\Component\Form\FormInterface;

class EditTaskHandler
{
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param FormInterface $form
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function editTaskHandle(FormInterface $form, Task $task)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskRepository->update($task);

            return true;
        }
        return false;
    }
}