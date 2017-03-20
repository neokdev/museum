<?php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class ClosedHolidayValidator
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class ClosedHolidayValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        $closedDays = ['01/05', '01/11', '25/12'];
        $dayActual = date('d/m', $value->getTimeStamp());

        foreach ($closedDays as $closedDay) {
            if ($closedDay === $dayActual) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}
