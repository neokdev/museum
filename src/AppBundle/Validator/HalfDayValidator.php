<?php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class HalfDayValidator
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class HalfDayValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        $actualDate = new \DateTime();

        $bookingUser = date('H', $value->getTimeStamp());
        if (!($bookingUser < $actualDate && $bookingUser < 14)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
