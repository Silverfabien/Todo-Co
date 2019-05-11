<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TaskRepository extends EntityRepository
{
    public function findAllTask($page = 6)
    {
        $limit = $page * 1;

        $query = $this->createQueryBuilder('t')
            ->orderBy('t.createdAt', 'ASC')
            ->setMaxResults($limit)
            ->getQuery();

        return $query->getResult();
    }
}