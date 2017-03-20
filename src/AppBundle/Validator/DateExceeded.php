<?php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class DateExceeded
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 *
 * @Annotation
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
