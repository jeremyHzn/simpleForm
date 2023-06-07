<?php

namespace App\Entity;

use App\Repository\QuestionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionsRepository::class)]
class Questions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private readonly string $email;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $question1 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $question2 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $question3 = null;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getQuestion1(): ?int
    {
        return $this->question1;
    }

    public function setQuestion1(?int $question1): self
    {
        $this->question1 = $question1;

        return $this;
    }

    public function isQuestion2(): ?bool
    {
        return $this->question2;
    }

    public function setQuestion2(?bool $question2): self
    {
        $this->question2 = $question2;

        return $this;
    }

    public function getQuestion3(): ?string
    {
        return $this->question3;
    }

    public function setQuestion3(?string $question3): self
    {
        $this->question3 = $question3;

        return $this;
    }
}
