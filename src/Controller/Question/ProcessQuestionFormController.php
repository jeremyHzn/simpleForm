<?php
declare(strict_types=1);

namespace App\Controller\Question;

use App\Form\SatisfactionFormType;
use App\Service\FormErrorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProcessQuestionFormController extends AbstractController
{

    #[Route(path: '/', name: 'app_main_post', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $questionForm = $this->createForm(
            type: SatisfactionFormType::class,
        );

        $questionForm->handleRequest($request);

        // make service of form
        if ($questionForm->isValid() === false) {
            $questionForm->$this->saveSubmittedDataInSession($questionForm->getData());

            $questionForm->$this->addFormErrorsInSession($questionForm);

            return $this->redirectToRoute('app_main');
        }

    }
}