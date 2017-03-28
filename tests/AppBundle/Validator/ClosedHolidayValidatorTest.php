<?php

namespace Tests\AppBundle\Validator;

use AppBundle\Validator\ClosedHoliday;
use AppBundle\Validator\ClosedHolidayValidator;

/**
 * Class ClosedHolidayValidatorTest
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class ClosedHolidayValidatorTest extends AbstractValidatorTest
{
    /**
     * {@inheritdoc}
     */
    public function testValidateOnInvalid()
    {
        $validator = $this->configureValidator($this->getConstraint()->message);

        $validator->validate(new \DateTime('05/01'), $this->getConstraint());
    }

    /**
     * Test Invalid for 25 december
     */
    public function testValidOnInvalidDecember()
    {
        $validator = $this->configureValidator($this->getConstraint()->message);

        $validator->validate(new \DateTime('12/25'), $this->getConstraint());
    }

    /**
     * Test invalid for 1st novembre
     */
    public function testValidOnInvalidNovembre()
    {
        $validator = $this->configureValidator($this->getConstraint()->message);

        $validator->validate(new \DateTime('11/01'), $this->getConstraint());
    }

    /**
     * {@inheritdoc}
     */
    public function testValidateOnValid()
    {
        $validator = $this->configureValidator();

        $validator->validate(new \DateTime('05/02'), $this->getConstraint());
    }

    /**
     * @return ClosedHoliday
     */
    public function getConstraint()
    {
        return new ClosedHoliday();
    }

    /**
     * {@inheritdoc}
     */
    public function getValidator()
    {
        return new ClosedHolidayValidator();
    }
}
