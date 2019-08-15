<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

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
class TaskRepository extends EntityRepository
{
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