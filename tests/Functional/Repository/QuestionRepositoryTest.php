<?php

declare(strict_types=1);

namespace App\Tests\Functional\Repository;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class QuestionRepositoryTest extends KernelTestCase
{
    private const EMAIL = 'test@example.com';

    private ?EntityManagerInterface $entityManager = null;

    private ?QuestionRepository $questionRepository = null;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get(
                id: 'doctrine'
            )
            ->getManager();

        $this->questionRepository = $this
            ->entityManager
            ->getRepository(Question::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();

        $this->entityManager = null;

        $this->questionRepository = null;
    }

    public function test_question_instance_database_persistance_works()
    {
        $this->commonLogic();
    }

    public function test_question_instance_database_remove_works()
    {
        $questionFromDatabase = $this->commonLogic();

        $this
            ->questionRepository
            ->remove(
                entity: $questionFromDatabase,
                flush: true
            );

        $questionFromDatabase = $this
            ->questionRepository
            ->findOneBy(
                criteria: [
                    'email' => self::EMAIL
                ]
            );

        $this->assertNotInstanceOf(
            expected: Question::class,
            actual: $questionFromDatabase
        );
    }

    private function commonLogic(): Question
    {
        $question = new Question(
            email: self::EMAIL
        );

        /** @var QuestionRepositoryTest $questionRepository */
        $this
            ->questionRepository
            ->save(
                entity: $question,
                flush: true
            );

        $questionFromDatabase = $this
            ->questionRepository
            ->findOneBy(
                criteria: [
                    'email' => self::EMAIL
                ]
            );

        $this->assertSame(
            expected: $question,
            actual: $questionFromDatabase
        );

        return $questionFromDatabase;
    }
}