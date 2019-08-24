<?php

namespace AppBundle\FormHandler;

use AppBundle\Entity\Task;
use AppBundle\Repository\TaskRepository;
use Symfony\Component\Form\FormInterface;

/**
 * Calling the form outside the controller
 *
 * @category
 * @package AppBundle\FormHandler
 * @author   Fabien Hollebeque <hollebeque.fabien@hotmail.com>
 * @license
 * @link
 */
class EditTaskHandler
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * EditTaskHandler constructor.
     *
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Edit Task Form
     *
     * @param FormInterface $form
     *
     * @return bool
     *
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