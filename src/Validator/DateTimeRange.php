<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DateTimeRange extends Constraint
{
    public $message = 'La date et l\'heure de réservation ne respectent pas les contraintes de plage horaire.';
}
