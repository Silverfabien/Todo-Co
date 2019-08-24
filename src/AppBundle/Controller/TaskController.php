<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use AppBundle\FormHandler\CreateTaskHandler;
use AppBundle\FormHandler\EditTaskHandler;
use AppBundle\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Controller that manages the tasks
 *
 * Class TaskController
 *
 * @category
 * @package  AppBundle\Controller
 * @author   Fabien Hollebeque <hollebeque.fabien@hotmail.com>
 * @license
 * @link
 */
class TaskController extends Controller
{
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Function that looks if the user has the required permission
     *
     * @param Task $task
     */
    private function checkPermission(Task $task)
    {
        if($task->getUser() != $this->getUser()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }
    }

    /**
     * Function that lists all the tasks
     *
     * @Route("/tasks", name="task_list")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        return $this->render('task/list.html.twig',
            ['tasks' => $this->getDoctrine()->getRepository('AppBundle:Task')->findAllTask()]
        );
    }

    /**
     * Create task page
     *
     * @Route("/tasks/create", name="task_create")
     *
     * @param Request $request
     * @param CreateTaskHandler $taskHandler
     * @param UserInterface $user
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createAction(Request $request, CreateTaskHandler $taskHandler, UserInterface $user)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task)->handleRequest($request);

        if ($taskHandler->createTaskHandle($form, $task, $user)) {
            $this->addFlash('success', 'La tâche a été bien été ajoutée.');
            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Edit page of a task with a permission check
     *
     * @Route("/tasks/{id}/edit", name="task_edit")
     *
     * @param Task $task
     * @param Request $request
     * @param EditTaskHandler $taskHandler
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function editAction(Task $task, Request $request, EditTaskHandler $taskHandler)
    {
        $this->checkPermission($task);

        $form = $this->createForm(TaskType::class, $task)->handleRequest($request);

        if ($taskHandler->editTaskHandle($form, $task)) {
            $this->addFlash('success', 'La tâche a bien été modifiée.');
            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', ['form' => $form->createView(), 'task' => $task]);
    }

    /**
     * Function that manages whether a task has been performed or not
     *
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     *
     * @param Task $task
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function toggleTaskAction(Task $task)
    {
        $this->checkPermission($task);

        $task->toggle(!$task->isDone());
        $this->taskRepository->update($task);

        $this->addFlash('success',
            sprintf('La tâche "%s" a bien été marquée comme %s réalisé.', $task->getTitle(), ($task->isDone())?'':'non')
        );

        return $this->redirectToRoute('task_list');
    }

    /**
     * Function that manages the deletion of tasks
     *
     * @Route("/tasks/{id}/delete", name="task_delete")
     *
     * @param Task $task
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteTaskAction(Task $task)
    {
        $this->checkPermission($task);

        $this->taskRepository->remove($task);

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }

    /**
     * Ajax function to display more tasks
     *
     * @Route("/task", name="task_load")
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function ajaxGetTask(Request $request)
    {
        $getRepo = $this->getDoctrine()->getRepository('AppBundle:Task');

        $task = ['tasks' => $this->render('task/item.html.twig',
            ['tasks' => $getRepo->findAllTask($request->get('page'))])->getContent(),
            'nbTask' => $getRepo->getNbTask()];

        return new JsonResponse($task);
    }
}