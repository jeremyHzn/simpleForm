<?php

namespace App\Controller\Question;

use App\Form\SatisfactionFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayQuestionFormController
{
    #[Route(path: '/', name: 'app_main', methods: ['GET'])]
    public function getForm(): Response
    {

        $questionForm = $this->createForm(
            type: SatisfactionFormType::class,
            data: $this->formErrorService->getSubmittedDataFromSession(),
            options:[
                'action' => $this->generateUrl(route:'app_main_post'),
                'method' => 'POST',
            ]
        );

        // form errror
        $questionForm->addFormErrorsFromPreviousSubmittedDataIfExists($questionForm);

        return $this->render(view: 'main/index.html.twig', parameters: [
            'questionForm' => $questionForm->createView()
        ]);
    }
}