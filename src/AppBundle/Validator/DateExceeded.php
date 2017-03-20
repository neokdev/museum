<?php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class DateExceeded
 *
 * @Annotation
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class DateExceeded extends Constraint
{
    public $message = 'Date entered is before today';

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
