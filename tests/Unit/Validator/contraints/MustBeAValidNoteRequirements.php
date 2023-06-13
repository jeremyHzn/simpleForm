<?php

declare(strict_types=1);

use App\Validator\Constraints\MustBeAValidNoteRequirement;
use Symfony\Component\Validator\Validation;

beforeEach(function () {
    $this->validator = Validation::createValidator();
});

test(
    description: 'Valid note pass MustBeAValidNoteRequirement constraint',
    closure: function (int $note) {
        $violations = $this
            ->validator
            ->validate(
                value: $note,
                constraints: [
                    new MustBeAValidNoteRequirement(),
                ]
            );

        expect(
            value: $violations
        )->toBeEmpty();
    }
)->with(
    data: [1, 2]
);

test(
    description: 'Not positive int does not pass MustBeAValidNoteRequirement constraint',
    closure: function (int $note) {
        $violations = $this
            ->validator
            ->validate(
                value: $note,
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
                expected: 'This value should be positive.'
            );
    }
)->with(
    data: [0, -1]
);

test(
    description: 'String note does not pass MustBeAValidNoteRequirement constraint',
    closure: function (string $note) {
        $violations = $this
            ->validator
            ->validate(
                value: $note,
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
                expected: 'This value should be of type integer.'
            );
    }
)->with(
    data: ["1", "2"]
);