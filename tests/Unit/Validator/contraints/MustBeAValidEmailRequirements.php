<?php

declare(strict_types=1);

use App\Validator\Constraints\MustBeAValidEmailRequirements;
use Symfony\Component\Validator\Validation;

beforeEach(function () {
    $this->validator = Validation::createValidator();
});

test(
    description: 'Valid email pass MustBeAValidEmailRequirements constraint',
    closure: function (string $email) {
        $violations = $this
            ->validator
            ->validate(
                value: $email,
                constraints: [
                    new MustBeAValidEmailRequirements(),
                ]
            );

        expect(
            value: $violations
        )->toBeEmpty();
    }
)->with(
    data: ['test@example.com']
);

test(
    description: 'Empty string, null, or false values doesn\'t pass MustBeAValidEmailRequirements constraint',
    closure: function (?string $email) {
        $violations = $this
            ->validator
            ->validate(
                value: $email,
                constraints: [
                    new MustBeAValidEmailRequirements(),
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
                expected: 'This value should not be blank.'
            );
    }
)->with(
    data: [
        '',
        null,
        false
    ]
);

test(
    description: 'Invalid email doesn\'t pass MustBeAValidEmailRequirements constraint',
    closure: function (?string $email) {
        $violations = $this
            ->validator
            ->validate(
                value: $email,
                constraints: [
                    new MustBeAValidEmailRequirements(),
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
                expected: 'This value is not a valid email address.'
            );

    }
)->with(
    data: [
        'test@example',
        'testexample.com',
        'testexamplecom',
        0,
        true
    ]
);