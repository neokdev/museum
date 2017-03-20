<?php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class ClosedHoliday
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class ClosedHoliday extends Constraint
{
    public $message = 'The museum is closed on May 1st, November 1st and December 25th.';

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
