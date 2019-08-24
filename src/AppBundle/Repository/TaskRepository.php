<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Repository for tasks
 *
 * Class TaskRepository
 *
 * @category
 * @package  AppBundle\Repository
 * @author   Fabien Hollebeque <hollebeque.fabien@hotmail.com>
 * @license
 * @link
 */
class TaskRepository extends ServiceEntityRepository
{
    /**
     * TaskRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @param $task
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Task $task)
    {
        $this->_em->persist($task);
        $this->_em->flush($task);
    }

    /**
     * @param $task
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Task $task)
    {
        $this->_em->flush($task);
    }

    /**
     * @param $task
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(Task $task)
    {
        $this->_em->remove($task);
        $this->_em->flush($task);
    }

    /**
     * Repository related to the Ajax function in the TaskController file
     *
     * @param int $page
     *
     * @return mixed
     */
    public function findAllTask($page = 6)
    {
        $limit = $page * 1;

        $query = $this->createQueryBuilder('t')
            ->orderBy('t.createdAt', 'ASC')
            ->setMaxResults($limit)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Repository related to the Ajax function in the TaskController file
     *
     * @return mixed
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getNbTask()
    {
        $nbTask = $this->createQueryBuilder('t')
            ->select('COUNT(t)')
            ->getQuery();

        return $nbTask->getSingleScalarResult();
    }
}