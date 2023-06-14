<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class MustNotAlreadyExistsInDatabaseValidator extends ConstraintValidator
{
    public function __construct(private readonly QuestionRepository $questionRepository)
    {
    }

    public function validate(
        mixed $value,
        Constraint $constraint
    ): void
    {
        if ($constraint instanceof MustNotAlreadyExistsInDatabase === false) {
            throw new UnexpectedTypeException(
                value: $constraint,
                expectedType: MustNotAlreadyExistsInDatabase::class
            );
        }

        if (
            $value === null
            ||
            $value === ''
        ) {
            return;
        }

        $questionInstance = $this
            ->questionRepository
            ->findOneBy(
                criteria: [
                    'email' => $value
                ]
            );

        if ($questionInstance instanceof Question === false) {
            return;
        }

        $this
            ->context
            ->buildViolation(
                message: $constraint->message
            )
            ->setParameter(
                key: '{{ string }}',
                value: $value
            )
            ->addViolation();
    }
}