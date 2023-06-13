<?php

declare(strict_types=1);

use App\Validator\Constraints\MustBeAValidNoteRequirement;
use Symfony\Component\Validator\Validation;

beforeEach(function () {
    $this->validator = Validation::createValidator();
});

test(
    description: "Valid values pass MustBeAValidNoteRequirement constraint",
    closure: function (?int $value) {
        $violations = $this
            ->validator
            ->validate(
                value: $value,
                constraints: [
                    new MustBeAValidNoteRequirement(),
                ]
            );

        expect(
            value: $violations
        )->toBeEmpty();
    }
)->with(
    data: [
        null,
        1,
        2,
        3,
        4,
        5,
    ]
);
test(
    description: "Invalid types of values does not pass MustBeAValidNoteRequirement constraint",
    closure: function (mixed $value) {
        $violations = $this
            ->validator
            ->validate(
                value: $value,
                constraints: [
                    new MustBeAValidNoteRequirement(),
                ]
            );

        expect(
            value: $violations
        )
            ->toHaveCount(
                count: 1
            )
            ->and($violations[0]->getMessage())
            ->toBe(
                expected: 'This value should be of type int.'
            );
    }
)->with(
    data: [
        '',
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        0.0,
        1.0,
        2.0,
        3.0,
        4.0,
        5.0,
        true,
        false,
        [],
        new stdClass(),
    ]
);
test(
    description: "Invalid values zero or -1 does not pass MustBeAValidNoteRequirement constraint",
    closure: function (int $value) {
        $violations = $this
            ->validator
            ->validate(
                value: $value,
                constraints: [
                    new MustBeAValidNoteRequirement(),
                ]
            );

        expect(
            value: $violations
        )
            ->toHaveCount(
                count: 1
            )
            ->and($violations[0]->getMessage())
            ->toBe(
                expected: 'This value should be Positive.'
            );
    }
)->with(
    data: [
        -1,
        0,
    ]
);
