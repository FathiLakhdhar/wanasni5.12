<?php

namespace Wanasni\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    public function getUsersByUsername($username){

        $qb=$this->createQueryBuilder('u');
        $qb->where('u.username LIKE :login')
            ->setParameter('login', '%'.$username.'%');

        return $qb->getQuery()->getResult();
    }
}
