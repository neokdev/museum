<?php

namespace Tests\AppBundle\Validator;

use AppBundle\Validator\DayClosed;
use AppBundle\Validator\DayClosedValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorInterface;

/**
 * Class DayClosedValidatorTest
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class DayClosedValidatorTest extends AbstractValidatorTest
{
    /**
     * {@inheritdoc}
     */
    public function testValidateOnInvalid()
    {
        $validator = $this->configureValidator($this->getConstraint()->message);

        $validator->validate(new \DateTime('2017/03/19'), $this->getConstraint());
    }

    /**
     * {@inheritdoc}
     */
    public function testValidateOnValid()
    {
        $validator = $this->configureValidator();

        $validator->validate(new \DateTime('2017/03/18'), $this->getConstraint());
    }

    /**
     * @return DayClosedValidator
     */
    public function getValidator()
    {
        return new DayClosedValidator();
    }

    /**
     * @return DayClosed
     */
    public function getConstraint()
    {
        return new DayClosed();
    }
}
