<?php

namespace AppBundle\Controller;

use AppBundle\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that manages security
 * See https://symfony.com/doc/3.4/security/guard_authentication.html
 *
 * Class SecurityController
 *
 * @category
 * @package  AppBundle\Controller
 * @author   Fabien Hollebeque <hollebeque.fabien@hotmail.com>
 * @license
 * @link
 */
class SecurityController extends Controller
{
    /**
     * Login page with the form
     *
     * @Route("/login", name="login")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        $form = $this->createForm(LoginType::class, [
            'username' => $this->get('security.authentication_utils')->getLastUsername()
        ]);

        return $this->render('security/login.html.twig', ['loginForm' => $form->createView()]);
    }

    /**
     * Code not used but requested in the Guard doc
     *
     * @Route("/login_check", name="login_check")
     *
     * @throws \Exception
     */
    public function loginCheck()
    {
        throw new \Exception('This code should not be reached');
    }

    /**
     * Code not used but requested in the Guard doc
     *
     * @Route("/logout", name="logout")
     *
     * @throws \Exception
     */
    public function logout()
    {
        throw new \Exception('This code should not be reached');
    }
}