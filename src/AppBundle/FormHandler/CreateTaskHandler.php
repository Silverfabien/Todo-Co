<?php

declare(ticks=1);

namespace AppBundle\FormHandler;

use AppBundle\Entity\Task;
use AppBundle\Repository\TaskRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Calling the form outside the controller
 *
 * @category
 * @package AppBundle\FormHandler
 * @author   Fabien Hollebeque <hollebeque.fabien@hotmail.com>
 * @license
 * @link
 */
class CreateTaskHandler
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * CreateTaskHandler constructor.
     *
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Create Task Form
     *
     * @param FormInterface $form
     * @param Task $task
     * @param UserInterface $user
     *
     * @return bool
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createTaskHandle(FormInterface $form, Task $task, UserInterface $user)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUser($user);

            $this->taskRepository->save($task);

            return true;
        }
        return false;
    }
}