<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Ticket;
use AppBundle\Entity\Order;

/**
 * Class TicketTest
 */
class TicketTest extends AbstractEntityTest
{

    /**
     * @return array
     */
    public function entityPropertyProvider()
    {
        $mockOrder = $this->getMockBuilder(Order::class)->getMock();

        return [
            ['id', 'integer', 10],
            ['firstname', 'string', 'John'],
            ['lastname', 'string', 'Doe'],
            ['birthDate', 'datetime', new \DateTime()],
            ['price', 'string', '10 euros'],
            ['order', 'object', $mockOrder],
        ];
    }

    /**
     * Get instance of entity to test.
     *
     * @return object
     */
    protected function getEntityInstance()
    {
        return new Ticket();
    }
}
