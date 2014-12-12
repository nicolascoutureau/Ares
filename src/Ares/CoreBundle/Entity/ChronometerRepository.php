<?php

namespace Ares\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ChronometerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ChronometerRepository extends EntityRepository
{
    public function myFindByTask($taskid){

        $qb = $this->_em->createQueryBuilder();
        $qb->select('c')
            ->from('AresCoreBundle:chronometer', 'c')
            ->InnerJoin('AresCoreBundle:usertask','ut')
            ->where("ut.id = c.usertask")
            ->andwhere("ut.task = $taskid");

        return $qb->getQuery()->getResult();
    }
}
