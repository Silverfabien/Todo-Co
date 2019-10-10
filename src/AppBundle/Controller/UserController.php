<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserEditPasswordType;
use AppBundle\Form\UserEditType;
use AppBundle\Form\UserType;
use AppBundle\FormHandler\CreateUserHandler;
use AppBundle\FormHandler\EditUserHandler;
use AppBundle\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller that manages users
 *
 * Class UserController
 *
 * @category
 * @package  AppBundle\Controller
 * @author   Fabien Hollebeque <hollebeque.fabien@hotmail.com>
 * @license
 * @link
 */
class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Function that lists all users
     *
     * @Route("/users", name="user_list")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        return $this->render('user/list.html.twig',
            ['users' => $this->getDoctrine()->getRepository('AppBundle:User')->findAll()]
        );
    }

    /**
     * Function that creates a user
     *
     * @Route("/users/create", name="user_create")
     *
     * @param Request $request
     * @param CreateUserHandler $userHandler
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createAction(Request $request, CreateUserHandler $userHandler)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user)->handleRequest($request);

        if ($userHandler->createUserHandle($form, $user)) {
            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['user' => $user, 'form' => $form->createView()]);
    }

    /**
     * Function that allows to change a user
     *
     * @Route("/users/{id}/edit", name="user_edit")
     *
     * @param User $user
     * @param Request $request
     * @param EditUserHandler $userHandler
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function editAction(User $user, Request $request, EditUserHandler $userHandler)
    {
        $form = $this->createForm(UserEditType::class, $user)->handleRequest($request);

        if ($userHandler->editUserHandle($form, $user)) {
            $this->addFlash('success', sprintf('L\'utilisateur "%s" a bien été modifié', $user->getUsername()));

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }

    /**
     * Function that allows to change password a user
     *
     * @Route("/users/{id}/edit_password", name="user_edit_password")
     *
     * @param User $user
     * @param Request $request
     * @param EditUserHandler $userHandler
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function editPasswordAction(User $user, Request $request, EditUserHandler $userHandler)
    {
        $form = $this->createForm(UserEditPasswordType::class, $user)->handleRequest($request);

        if($userHandler->editUserPasswordHandle($form, $user)) {
            $this->addFlash('success', sprintf('Le mot de passe de "%s" a bien été modifier', $user->getUsername()));

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/editPassword.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }


}