<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;

class MustBeAValidTextAreaRequirement extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Type(type:"Text"),
            new LessThanOrEqual(4000)
        ];
    }
}