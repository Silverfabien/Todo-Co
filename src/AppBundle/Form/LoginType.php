<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Login form
 *
 * Class LoginType
 *
 * @category
 * @package  AppBundle\Form
 * @author   Fabien Hollebeque <hollebeque.fabien@hotmail.com>
 * @license
 * @link
 */
class LoginType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['label' => "Nom d'utilisateur"])
            ->add('password', PasswordType::class, ['label' => "Mot de passe"]);
    }
}