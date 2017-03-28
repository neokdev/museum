<?php

namespace tests\AppBundle\Form\Type;

use AppBundle\Form\Type\TicketType;

/**
 * Class TicketTypeTest
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class TicketTypeTest extends AbstractTypeTest
{

    /**
     * Test to submit valid data
     *
     * @return mixed
     */
    public function testSubmitedValidData()
    {
        $formData = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'birthDate' => '01/01/1980',
            'nationality' => 'France',
            'reduction' => true,
        ];

        $form = $this->factory->create(TicketType::class);
        $form->submit($formData);

        static::assertTrue($form->isSynchronized());
    }
}
