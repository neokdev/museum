<?php

namespace AppBundle\Services;

use AppBundle\Entity\Ticket;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class TicketManager.
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class TicketManager
{
    /** @var EntityManager */
    private $em;

    /** @var Session */
    private $session;

    /**
     * TicketManager constructor.
     *
     * @param EntityManager $em
     * @param Session       $session
     */
    public function __construct(EntityManager $em, Session $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    /**
     * Display a flash message if remaining available ticket for the current day is under 100.
     */
    public function isUnderLimitTicket()
    {
        $actualDate = new \DateTime();

        if ((1000 - count($this->em->getRepository(Ticket::class)->getTicketsByDay($actualDate))) < 100) {
            $this->session->getFlashBag()->add(
                'alert',
                'Il reste moins de 100 billets disponible sur la journée en cours, ne perdez pas de temps'
            );
        }
    }
}
