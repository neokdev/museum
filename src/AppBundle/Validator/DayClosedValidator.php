<?php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class DayClosedValidator
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class DayClosedValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        $closedDays = ['Tue', 'Sun'];

        $dayChoose = date('D', $value->getTimeStamp());

        foreach ($closedDays as $closedDay) {
            if ($closedDay == $dayChoose) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}
