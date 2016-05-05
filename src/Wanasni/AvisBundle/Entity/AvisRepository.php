<?php

namespace Wanasni\AvisBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AvisRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AvisRepository extends EntityRepository
{


    public function CountAllAvis($user)
    {
        return $this->createQueryBuilder('a')
                ->select('COUNT(a)')
                ->where('a.recepteur = :id')
                ->setParameter('id',$user->getId())
                ->getQuery()
                ->getSingleScalarResult();
        
    }
    public function CountAvisBy($user, $avis)
    {
        return $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->where('a.recepteur = :id')
            ->setParameter('id',$user->getId())
            ->andWhere('a.global LIKE :avis')
            ->setParameter('avis',$avis)
            ->getQuery()
            ->getSingleScalarResult();

    }


}
