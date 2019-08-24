<?php

namespace AppBundle\FormHandler;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class EditUserHandler
{
    private $userRepository;

    private $passwordEncoder;

    public function __construct(UserRepository $userRepository, UserPasswordEncoder $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param FormInterface $form
     * @param User $user
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function editUserHandle(FormInterface $form, User $user)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());

            $user->setPassword($password);

            $this->userRepository->update();

            return true;
        }
        return false;
    }
}