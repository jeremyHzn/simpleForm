<?php
declare(strict_types=1);

namespace App\Controller\Question;

use App\Entity\Question;
use App\Form\SatisfactionFormType;
use App\Repository\QuestionRepository;
use App\Service\FormErrorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProcessQuestionFormController
 * @package App\Controller\Question
 */
final class ProcessQuestionFormController extends AbstractController
{

    /**
     * @param FormErrorService $formErrorService
     * @param QuestionRepository $questionRepository
     */
    public function __construct(private readonly FormErrorService $formErrorService,private readonly QuestionRepository $questionRepository) {}

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    #[Route(path: '/', name: 'app_main_post', methods: ['POST'])]
    public function __invoke(Request $request): RedirectResponse
    {
        $questionForm = $this->createForm(
            type: SatisfactionFormType::class,
        );

        $questionForm->handleRequest($request);

        $submittedData = $questionForm->getData();

        if (is_array($submittedData) === false) {
            throw new \LogicException(
                message: 'Submitted data must be an array.'
            );
        }

        if ($questionForm->isValid() === false) {
            $this->formErrorService->saveSubmittedDataInSession($submittedData);

            $this->formErrorService->addFormErrorsInSession($questionForm);

            return $this->redirectToRoute('app_main');
        }

        $question = $this->makeQuestion($submittedData);
        $this->questionRepository->save(entity:$question, flush: true);

        $this->addFlash(
            type:'notice',
            message:'Merci pour votre retour !'
        );

        return $this->redirectToRoute(route:'app_main');
    }

    /**
     * @param array $questionForm
     * @return Question
     */
    private function makeQuestion(array $questionForm): Question
    {
        [
            'email' => $email,
            'question1' => $question1,
            'question2' => $question2,
            'question3' => $question3,
        ] = $questionForm;

        return new Question(
            email: $email,
            question1: $question1,
            question2: $question2,
            question3: $question3
        );
    }

}