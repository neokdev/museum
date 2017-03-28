<?php

namespace tests\AppBundle\Form\Type;

use AppBundle\Form\Type\SearchOrderType;

/**
 * Class SearchOrderTypeTest
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class SearchOrderTypeTest extends AbstractTypeTest
{
    /**
     * {@inheritdoc}
     */
    public function testSubmitedValidData()
    {
        $formData = [
            'email' => 'john@doe.com',
        ];

        $form = $this->factory->create(SearchOrderType::class);
        $form->submit($formData);

        static::assertTrue($form->isSynchronized());
    }
}
