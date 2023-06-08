<?php

namespace App\Controller\Question;

use App\Form\SatisfactionFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProcessQuestionFormController
{
    #[Route(path: '/', name: 'app_main_post', methods: ['POST'])]
    public function postForm(Request $request): Response
    {
        $questionForm = $this->createForm(
            type: SatisfactionFormType::class,
        );

        $questionForm->handleRequest($request);

        // make service of form
        if ($questionForm->isValid() === false) {
            $formErrorService->saveSubmittedDataInSession($questionForm->getData());

            $formErrorService->addFormErrorsInSession($questionForm);

            return $this->redirectToRoute('app_main');
        }

    }
}