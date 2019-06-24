<?php

namespace AppBundle\Listener;

use AppBundle\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class EncodePasswordListener implements EventSubscriber
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function getSubscribedEvents()
    {
        return ['prePersist', 'preUpdate'];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof User) {
            return;
        }

        $passwordEncoder = $this->encoderFactory->getEncoder(get_class($entity));

        if ($passwordEncoder instanceof BCryptPasswordEncoder) {
            $entity->setSalt(null);
        } else {
            $salt = rtrim(str_replace('+', '.', base64_encode(random_bytes(32))), '=');
            $entity->setSalt($salt);
        }

        $this->encodePassword($entity, $passwordEncoder);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if(!$entity instanceof User) {
            return;
        }

        $passwordEncoder = $this->encoderFactory->getEncoder(get_class($entity));
        $this->encodePassword($entity, $passwordEncoder);

        $em = $args->getEntityManager();
        $meta = $em->getClassMetadata(get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
    }

    public function encodePassword(User $entity, PasswordEncoderInterface $passwordEncoder)
    {
        if(!$entity->getPlainPassword()) {
            return;
        }

        $encoded = $passwordEncoder->encodePassword($entity->getPlainPassword(), $entity->getSalt());
        $entity->setPassword($encoded);
    }
}