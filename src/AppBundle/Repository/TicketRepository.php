<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class TicketRepository.
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class TicketRepository extends EntityRepository
{
    /**
     * Return list of tickets by day.
     *
     * @param \DateTime $date Date of selected day
     *
     * @return array
     */
    public function getTicketsByDay(\DateTime $date)
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.order', 'orderRegistration')
            ->addSelect('orderRegistration')
            ->where('orderRegistration.dateVisit = :visit')
            ->setParameter('visit', $date)
            ->getQuery()
            ->getResult();
    }
}
