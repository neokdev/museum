<?php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class HalfDay
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class HalfDay extends Constraint
{
    public $message = 'You can no longer book your ticket for the full day as it is past 14.00';

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
