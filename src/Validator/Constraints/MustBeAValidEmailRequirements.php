<?php
declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

final class MustBeAValidEmailRequirements extends Compound
{
    /**
     * @param array $options
     * @return array|\Symfony\Component\Validator\Constraint[]
     */
    protected function getConstraints(array $options): array
    {
        return [
            new NotBlank(),
            new Email(),
        ];
    }
}