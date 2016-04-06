<?php

namespace Wanasni\TrajetBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TrajetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TrajetRepository extends EntityRepository
{

    public function getTrajetById($id){
        $qb = $this->createQueryBuilder('t');
        $qb
            ->join('t.Origine', 'o')
            ->addSelect('o')
            ->join('t.Destination', 'd')
            ->addSelect('d')
            ->join('t.Segments', 's')
            ->addSelect('s')
            ->join('t.datesAller', 'da')
            ->addSelect('da')
            ->join('t.datesRetour', 'dr')
            ->addSelect('dr')
            ->where('t.id = :id')
            ->setParameter('id',$id)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }



    public function SearchByOrigineAndDestination($depart,$arrive,$date){
        $qb = $this->createQueryBuilder('t');

        $qb->join('t.Origine', 'origine')
            ->join('t.Destination','destination')
            ->join('t.datesAller','datesAller')
            ->join('t.datesRetour','datesRetour')
            ->where('origine.lieu LIKE :depart')
            ->setParameter('depart', '%'.$depart.'%')
            ->andWhere('destination.lieu LIKE :arrive')
            ->setParameter('arrive', '%'.$arrive.'%')
            ->andWhere('datesAller.date = :dateA OR datesRetour.date = :dateR')
            ->setParameter('dateA', date_create($date))
            ->setParameter('dateR', date_create($date))

        ;


        return $qb->getQuery()->getResult();
    }

}
