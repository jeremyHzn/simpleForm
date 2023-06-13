<?php
declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;

final class MustBeAValidNoteRequirement extends Compound
{
    /**
     * @param array $options
     * @return array|\Symfony\Component\Validator\Constraint[]
     */
    protected function getConstraints(array $options): array
    {
        return [
            new Positive(),
            new Type(type:"integer"),
        ];
    }
}