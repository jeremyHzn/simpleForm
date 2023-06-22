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


    public function findAllQuestionAndCountReponseDataProvider(): array
    {

        return [
            'test_1' => [
                'questions' => [
                    'question_1' => [
                        'email' => 'test1_question1@example.com',
                        'question1' => 3,
                        'question2' => false
                    ],
                    'question_2' => [
                        'email' => 'test1_question2@example.com',
                        'question1' => 5,
                        'question2' => true
                    ],
                    'question_3' => [
                        'email' => 'test1_question3@example.com',
                        'question1' => 5,
                        'question2' => null
                    ],
                    'question_4' => [
                        'email' => 'test1_question4@example.com',
                        'question1' => 2,
                        'question2' => true

                    ],
                    'question_5' => [
                        'email' => 'test1_question5@example.com',
                        'question1' => 4,
                        'question2' => false
                    ]
                ]
            ],
            'test_2' => [
                'questions' => [
                    'question_1' => [
                        'email' => 'test2_question1@example.com',
                        'question1' => 1,
                        'question2' => false
                    ],
                    'question_2' => [
                        'email' => 'test2_question2@example.com',
                        'question1' => 4,
                        'question2' => false
                    ],
                    'question_3' => [
                        'email' => 'test3_question3@example.com',
                        'question1' => 2,
                        'question2' => true
                    ],
                    'question_4' => [
                        'email' => 'test1_question4@example.com',
                        'question1' => 2,
                        'question2' => null

                    ],
                    'question_5' => [
                        'email' => 'test2_question5@example.com',
                        'question1' => 5,
                        'question2' => false
                    ]
                ],
                'expected_result' => [
                    [
                        'email_count' => 5,
                        'question1_1_count' => 1,
                        'question1_2_count' => 2,
                        'question1_3_count' => 0,
                        'question1_4_count' => 1,
                        'question1_5_count' => 1,
                        'question2_yes_count' => 1,
                        'question2_no_count' => 3,
                        'question2_null_count' => 1,
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider findAllQuestionAndCountReponseDataProvider
     */
    public function test_find_all_question_and_count_result_method_works(array $testData)
    {
        foreach ($testData as $key => $testDatum) {
            [
                'email' => $email,
                'question1' => $question1,
                'question2' => $question2,
            ] = $testDatum;

            $question = new Question(
                email: $email,
                question1: $question1,
                question2: $question2
            );

            if ($key !== 'question_5') {
                $this
                    ->questionRepository
                    ->save(
                        entity: $question
                    );

                continue;
            }

            $this
                ->questionRepository
                ->save(
                    entity: $question,
                    flush: true
                );
        }

        dd('stop');
    }
}
















