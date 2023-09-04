<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PasswordConstraints extends Constraint
{
    public $message = 'Le mot de passe doit avoir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.';
}
