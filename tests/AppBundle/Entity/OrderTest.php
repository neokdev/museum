<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Order;
use AppBundle\Entity\Ticket;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class OrderTest
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class OrderTest extends AbstractEntityTest
{
    /**
     * Return an array of property to assert all method
     *
     * @return array
     */
    public function entityPropertyProvider()
    {
        $mockTicket = $this->getMockBuilder(Ticket::class)->getMock();

        return [
            ['id', 'integer', 10],
            ['dateVisit', 'datetime', new \DateTime()],
            ['typeTicket', 'string', 'Demi-journée'],
            ['email', 'string', 'john@doe.com'],
            ['orderNumber', 'string', 'ABCDE123456!'],
            ['numberTickets', 'string', '4'],
            ['totalPrice', 'string', '250.00'],
            ['valid', 'boolean', false],
            ['dateOrder', 'datetime', new \DateTime()],
            ['tickets', 'collection', new ArrayCollection([$mockTicket])],
        ];
    }

    /**
     * Get instance of entity to test.
     *
     * @return object
     */
    protected function getEntityInstance()
    {
//        return new Order();
    }
}
