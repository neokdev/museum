<?php

namespace Tests\AppBundle\Validator;

use AppBundle\Validator\DateExceeded;
use AppBundle\Validator\DateExceededValidator;

/**
 * Class DateExceededValidator
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class DateExceededValidatorTest extends AbstractValidatorTest
{
    /**
     * {@inheritdoc}
     */
    public function testValidateOnInvalid()
    {
        $validator = $this->configureValidator($this->getConstraint()->message);

        $validator->validate('2016/01/01', $this->getConstraint());
    }

    /**
     * {@inheritdoc}
     */
    public function testValidateOnValid()
    {
        $validator = $this->configureValidator($this->getConstraint()->message);

        $validator->validate('2017/04/30', $this->getConstraint());
    }

    /**
     * @return DateExceededValidator
     */
    public function getValidator()
    {
        return new DateExceededValidator();
    }

    /**
     * {@inheritdoc}
     */
    public function getConstraint()
    {
        return new DateExceeded();
    }
}
