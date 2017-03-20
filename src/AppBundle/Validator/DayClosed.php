<?php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class DayClosed
 *
 * @Annotation
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class DayClosed extends Constraint
{
    public $message = 'You can\'t booking on a closed day';

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
