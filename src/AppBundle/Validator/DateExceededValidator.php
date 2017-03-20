<?php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class DateExceededValidator
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class DateExceededValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        $actualDate = new \DateTime();
        if ($value < $actualDate) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
