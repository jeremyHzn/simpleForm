<?php

declare(strict_types=1);

namespace App\Controller\Question;

use App\Form\SatisfactionFormType;
use App\Service\FormErrorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DisplayQuestionFormController extends AbstractController
{

    public function __construct(private readonly FormErrorService $formErrorService) {}


    #[Route(path: '/', name: 'app_main', methods: ['GET'])]
    public function __invoke(): Response
    {
        $formErrorService = $this->createForm(
            type: SatisfactionFormType::class,
            data: $this->formErrorService->getSubmittedDataFromSession(),
            options:[
                'action' => $this->generateUrl(route:'app_main_post'),
                'method' => 'POST',
            ]
        );

        // form errror
        $formErrorService->$this->addFormErrorsFromPreviousSubmittedDataIfExists($formErrorService);

        return $this->render(view: 'main/index.html.twig', parameters: [
            'formErrorService' => $formErrorService->createView()
        ]);
    }
}