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
            ['id', 'inte', 10],
            ['dateVisit', 'datetime', new \DateTime()],
            ['typeTicket', 'string', 'Demi-journée'],
            ['email', 'string', 'john@doe.com'],
            ['orderNumber', 'string', 'ABCDE123456!'],
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
