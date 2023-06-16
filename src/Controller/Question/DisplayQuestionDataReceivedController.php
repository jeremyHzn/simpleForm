<?php
declare(strict_types=1);

namespace App\Controller\Question;

use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DisplayQuestionDataReceivedController extends AbstractController
{
    public function __construct(private readonly QuestionRepository $questionRepository) {}

    #[Route(path: '/response', name: 'app_response', methods: ['GET'])]
    public function __invoke(): Response
    {

        return $this->render(view: 'response/index.html.twig', parameters: [
                "responses" => $this->questionRepository->findAllQuestion1AndQuestion2Count()
            ]
        );
    }
}