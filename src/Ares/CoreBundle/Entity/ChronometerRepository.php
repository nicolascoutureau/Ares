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

    /**
     * Retourne tous les chronometres d'une tache donnée
     * @param $taskid
     * @return array
     */
    public function myFindByTask($taskid){

        $qb = $this->_em->createQueryBuilder();
        $qb->select('c')
            ->from('AresCoreBundle:chronometer', 'c')
            ->InnerJoin('AresCoreBundle:usertask','ut')
            ->where("ut.id = c.usertask")
            ->andwhere("ut.task = $taskid");

        return $qb->getQuery()->getResult();
    }

    /**
     * Retourne les chronometres en fonction d'une tache et d'un utilisateur
     * @param $userid
     * @param $taskid
     * @return array
     */
    public function myFindChronometerByUserAndTask($userid,$taskid)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('c')
           ->from('AresCoreBundle:Chronometer', 'c')
           ->innerJoin('AresCoreBundle:Usertask','ut')
           ->where("ut.user = $userid ")
           ->andWhere("ut.task = $taskid")
           ->orderBy('c.startdate', 'desc')
           ->getFirstResult();

        return $qb->getQuery()->getResult();

    }
}
