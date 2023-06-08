<?php
declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

final class MustBeAValidEmailRequirements extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new NotBlank(),
            new Email(),
        ];
    }
}