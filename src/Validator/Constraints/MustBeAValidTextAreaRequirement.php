<?php
declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

final class MustBeAValidTextAreaRequirement extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Type(type:"string"),
            new Length(min: 0, max: 4000),
        ];
    }
}