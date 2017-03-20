<?php

namespace Tests\AppBundle\Validator;

use AppBundle\Validator\HalfDay;
use AppBundle\Validator\HalfDayValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorInterface;

/**
 * Class HalfDayValidatorTest
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class HalfDayValidatorTest extends AbstractValidatorTest
{
    /**
     * {@inheritdoc}
     */
    public function testValidateOnInvalid()
    {
        $validator = $this->configureValidator($this->getConstraint()->message);

        $dateRegistration = new \DateTime();

        $validator->validate($dateRegistration, $this->getConstraint());
    }

    /**
     * Test empty
     */
    public function testValidateOnValid()
    {
        $validator = $this->configureValidator();
        $dateRegistration = new \DateTime('2090/01/01');

        $validator->validate($dateRegistration, $this->getConstraint());
    }

    /**
     * @return HalfDayValidator
     */
    public function getValidator()
    {
        return new HalfDayValidator();
    }

    /**
     * @return HalfDay
     */
    public function getConstraint()
    {
        return new HalfDay();
    }
}
