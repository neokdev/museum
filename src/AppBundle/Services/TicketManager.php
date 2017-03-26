<?php

namespace AppBundle\Services;

use AppBundle\Entity\Order;
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

    /** @var int */
    private $priceTicket;

    /** @var int */
    private $totalPrice;

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

    /**
     * @param Order $order
     *
     * @return Order
     */
    public function getTotalPriceOrder(Order $order)
    {
        $tickets = $order->getTickets();
        foreach ($tickets as $ticket) {
            try {
                if (!is_object($ticket->getBirthDate() && !is_object($order->getDateVisit()))) {
                    throw new \InvalidArgumentException(
                        sprintf(
                            'Must be an object, %s given',
                            gettype([$ticket->getBirthDate(), $order->getDateVisit()])
                        )
                    );
                }
            } catch (\InvalidArgumentException $exception) {
                $exception->getMessage();
            }

            $age = date_diff($ticket->getBirthDate(), $order->getDateVisit())->y;
            $priceTicket = $this->setPriceForEachTicket($ticket->isReduction(), $age);
            $ticket->setPrice($priceTicket);

            $this->totalPrice += $ticket->getPrice();
            $order->setTotalPrice($this->totalPrice);
        }

        return $order;
    }

    /**
     * @param $reduction
     * @param $age
     *
     * @return int
     */
    private function setPriceForEachTicket($reduction, $age)
    {
        switch ($age) {
            case $age < 4:
                $this->priceTicket = 0;
                break;
            case $age > 4 && $age < 12:
                $this->priceTicket = 8;
                break;
            case $reduction:
                $this->priceTicket = 10;
                break;
            case $age >= 60:
                $this->priceTicket = 12;
                break;
            default:
                $this->priceTicket = 16;
                break;
        }

        return $this->priceTicket;
    }
}
