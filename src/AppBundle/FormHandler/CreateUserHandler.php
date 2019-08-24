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
class CreateUserHandler
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
     * CreateUserHandler constructor.
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
     * Create User Form
     *
     * @param FormInterface $form
     * @param User $user
     *
     * @return bool
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createUserHandle(FormInterface $form, User $user)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());

            $user->setPassword($password);

            $this->userRepository->save($user);

            return true;
        }
        return false;
    }
}