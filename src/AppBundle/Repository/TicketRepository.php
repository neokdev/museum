<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class TicketRepository
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class TicketRepository extends EntityRepository
{
    /**
     * Return list of tickets by day
     *
     * @return array
     */
    public function getTicketsByDay()
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.order', 'order')
            ->addSelect('order')
            ->where('order.dateVisit = :date')
            ->setParameter('date', new \DateTime())
            ->getQuery()
            ->getResult();
    }
}
