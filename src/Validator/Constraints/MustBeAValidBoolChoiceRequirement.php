<?php
declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;

final class MustBeAValidBoolChoiceRequirement extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Choice(choices: [
                'Oui',
                'Non',
                'Ne sais pas'
            ]),
        ];
    }
}