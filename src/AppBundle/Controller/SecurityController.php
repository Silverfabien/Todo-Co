<?php

namespace AppBundle\Controller;

use AppBundle\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        $form = $this->createForm(LoginType::class, [
            'username' => $this->get('security.authentication_utils')->getLastUsername()
        ]);

        return $this->render('security/login.html.twig', ['loginForm' => $form->createView()]);
    }

    /**
     * @Route("/login_check", name="login_check")
     * @throws \Exception
     */
    public function loginCheck()
    {
        throw new \Exception('This code should not be reached');
    }

    /**
     * @Route("/logout", name="logout")
     * @throws \Exception
     */
    public function logout()
    {
        throw new \Exception('This code should not be reached');
    }
}