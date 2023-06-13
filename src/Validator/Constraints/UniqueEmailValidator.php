<?php
declare(strict_types=1);

namespace App\Validator\Constraints;
use App\Entity\Question;
use App\Repository\QuestionRepository;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final class UniqueEmailValidator
{
    public function __construct(private readonly QuestionRepository $questionRepository)
    {}

    public static function uniqueEmailValidation($data, ExecutionContextInterface $context): void
    {
        $existingEntity = $this->questionRepository->findOneBy(['email' => $data['email']);

        if ($existingEntity instanceof Question === true) {
            $context->buildViolation('Cet e-mail est déjà utilisé.')
                ->atPath('email')
                ->addViolation();
        }
    }
}