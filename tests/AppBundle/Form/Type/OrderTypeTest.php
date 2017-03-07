<?php

namespace tests\AppBundle\Form\Type;

use AppBundle\Form\Type\OrderType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class OrderTypeTest
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class OrderTypeTest extends TypeTestCase
{
    /**
     * Test order form
     */
    public function testSubmittedDate()
    {
        $formData = [
            'email' => 'john@doe.com',
            'dateVisit' => new \DateTime('01-05-2017'),
            'numberTickets' => '1',
            'typeTicket' => 'Journée',
        ];

        $form = $this->factory->create(OrderType::class);

        $form->submit($formData);

        static::assertTrue($form->isSynchronized());
    }
}
