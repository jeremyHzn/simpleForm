<?php

declare(strict_types=1);

use App\Entity\Question;

beforeEach(function () {
    $this->email = 'test@example.com';
});

test(
    description: 'Question in valid state with only email passed as valid value',
    closure: function () {
        $question = new Question(
            email: $this->email
        );

        expect(
            value: $question->email
        )->toBe(
            expected: $this->email
        );
    }
);

test(
    description: 'Question in invalid state with only email passed as invalid value',
    closure: function () {
        new Question(
            email: null
        );
    }
)->throws(
    exception: TypeError::class,
    exceptionMessage: 'Argument #1 ($email) must be of type string, null given'
);

test(
    description: 'Question in valid state with only email and question1 passed as valid values',
    closure: function () {
        $question1 = 3;

        $question = new Question(
            email: $this->email,
            question1: $question1
        );

        expect(
            value: $question->question1
        )->toBe(
            expected: $question1
        );
    }
);

test(
    description: 'Question in valid state with only email and question2 passed as valid values',
    closure: function () {
        $question2 = false;

        $question = new Question(
            email: $this->email,
            question2: $question2
        );

        expect(
            value: $question->question2
        )->toBe(
            expected: $question2
        );
    }
);

test(
    description: 'Question in valid state with only email and question3 passed as valid values',
    closure: function () {
        $question3 = 'toto';

        $question = new Question(
            email: $this->email,
            question3: $question3
        );

        expect(
            value: $question->question3
        )->toBe(
            expected: $question3
        );
    }
);