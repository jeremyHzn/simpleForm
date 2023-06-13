<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ORM\Table(name: 'questions')]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    readonly string $email;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    readonly ?int $question1;

    #[ORM\Column(nullable: true)]
    readonly ?bool $question2;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    readonly ?string $question3;

    public function __construct(
        string $email,
        ?int $question1 = null,
        ?bool $question2 = null,
        ?string $question3 = null
    )
    {
        $this->email = $email;
        $this->question1 = $question1;
        $this->question2 = $question2;
        $this->question3 = $question3;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

}
