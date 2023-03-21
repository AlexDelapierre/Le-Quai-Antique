<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FrenchPhoneNumberValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var App\Validator\FrenchPhoneNumber $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        //On vérifie que le numéro commence par un 0 et est suivi de 9 chiffres, sinon ...
        //on créer une violation dans notre context. 
        //(une erreur avec le message de la contrainte et on lui passe en paramêtre la valeur de value...
        //pour pouvoir la remplacer dans notre message d'erreur situé dans FrenchPhoneNumber.php).
        if (!preg_match('/^0\d{9}$/', $value)) {
            $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
        }
    }
}
