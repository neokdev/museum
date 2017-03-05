<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Order;
use AppBundle\Entity\Ticket;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class OrderTest
 */
class OrderTest extends AbstractEntityTest
{
    /**
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
            ['totalPrice', 'string', '250.00'],
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
        return new Order();
    }
}
