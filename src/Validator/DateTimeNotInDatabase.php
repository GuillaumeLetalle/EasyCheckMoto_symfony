<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DateTimeNotInDatabase extends Constraint
{
    public $message = 'Cette date et heure sont déjà réservées.';
}
