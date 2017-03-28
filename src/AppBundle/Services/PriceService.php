<?php

namespace AppBundle\Services;

use AppBundle\Entity\Order;

/**
 * Class PriceService.
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class PriceService
{
    /** @var int Price for each ticket */
    private $priceTicket;

    /** @var int Price for total order */
    private $totalPrice;

    /**
     * @param Order $order
     *
     * @return Order
     */
    public function setTotalPriceOrder(Order $order)
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

            $order->getTypeTicket() == 1 ? $ticket->setPrice($priceTicket / 2) : $ticket->setPrice($priceTicket);

            $ticket->setOrder($order);

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
