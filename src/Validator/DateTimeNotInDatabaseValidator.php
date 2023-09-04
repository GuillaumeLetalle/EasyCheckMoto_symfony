<?php

namespace App\Validator;

use App\Entity\CT;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManagerInterface;

class DateTimeNotInDatabaseValidator extends ConstraintValidator
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($value, Constraint $constraint)
    {
        
        // vérifiez si la date et l'heure existent déjà dans la base de données
        $existingReservation = $this->entityManager->getRepository(CT::class)->findOneBy(['debut' => $value]);

        if ($existingReservation !== null) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
