<?php

namespace tests\AppBundle\Form\Type;

use AppBundle\Form\Type\ContactType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class ContactTypeTest
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class ContactTypeTest extends TypeTestCase
{
    /**
     * Test contact form
     */
    public function testSubmitedValidData()
    {
        $formData = [
            'name' => 'name1',
            'email' => 'email1@test.com',
            'subject' => 'subject1',
            'message' => 'message1',
        ];

        $form = $this->factory->create(ContactType::class);

        static::assertEquals('contact', $form->getName());

        $form->submit($formData);

        static::assertTrue($form->isSynchronized());
    }
}
