<?php

namespace Wanasni\PhotoBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PhotoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PhotoRepository extends EntityRepository
{


    public function getPhotosNotValid()
    {
        $q= $this->createQueryBuilder('p');
        $q
            ->where('p.valid = false')
            ->andWhere('p.path IS NOT NULL')

        ;


        return $q->getQuery()->getResult();
        
    }
    
    
}
