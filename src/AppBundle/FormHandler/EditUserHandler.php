<?php

namespace AppBundle\FormHandler;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

/**
 * Calling the form outside the controller
 *
 * @category
 * @package AppBundle\FormHandler
 * @author   Fabien Hollebeque <hollebeque.fabien@hotmail.com>
 * @license
 * @link
 */
class EditUserHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserPasswordEncoder
     */
    private $passwordEncoder;

    /**
     * EditUserHandler constructor.
     *
     * @param UserRepository $userRepository
     * @param UserPasswordEncoder $passwordEncoder
     */
    public function __construct(UserRepository $userRepository, UserPasswordEncoder $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Edit User Form
     *
     * @param FormInterface $form
     * @param User $user
     *
     * @return bool
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function editUserHandle(FormInterface $form, User $user)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->update($user);

            return true;
        }
        return false;
    }
}