<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
final class MustNotAlreadyExistsInDatabase extends Constraint
{
    public string $message = 'The email "{{ string }}" cannot be used. Please enter another email.';
}