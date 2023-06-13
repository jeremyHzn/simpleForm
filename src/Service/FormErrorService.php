<?php

declare(strict_types=1);

namespace App\Service;

use App\Controller\FormErrorInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final readonly class FormErrorService implements FormErrorInterface
{
    private SessionInterface $session;

    /**
     * @param RequestStack $requestStack
     * get session from request stack and assign it to $session to use methods from SessionInterface without passing it as a parameter
     */
    public function __construct(private RequestStack $requestStack)
    {
        $this->session = $this
            ->requestStack
            ->getSession();
    }

    /**
     * @return array|null
     * Returns the value requestStack of the session variable named 'submitted_data' as an array.
     */
    public function getSubmittedDataFromSession(): ?array
    {
        return $this
                ->session
                ->remove(
                    name: 'submitted_data',
                );
            if (is_array($submittedData) === false) {
                return null;
            }

        return $submittedData;
    }

    /**
     * @param array $submittedData
     * @return void
     * Sets the value of the session variable named 'submitted_data' to the value of the $submittedData parameter.
     */
    public function saveSubmittedDataInSession(array $submittedData): void
    {
        $this
            ->session
            ->set(
                name: 'submitted_data',
                value: $submittedData
            );
    }

    /**
     * @param FormInterface $form
     * @return void
     * Gets all errors from the form and its children and sets them in the session variable named 'form_errors'.
     */
    public function addFormErrorsInSession(FormInterface $form): void
    {
        $formErrors = $form->getErrors(
            deep: true
        );

        if (count($formErrors) === 0) {
            return;
        }

        $formErrorsForSession = [];

        foreach ($formErrors as $formError) {
            /** @var FormError $formError */
            $formErrorsForSession[] = [
                'message' => $formError->getMessage(),
                'origin' => $formError
                    ->getOrigin()
                    ?->getName()
            ];
        }

        $this
            ->session
            ->set(
                name: 'form_errors',
                value: $formErrorsForSession
            );
    }

    /**
     * @param FormInterface $form
     * @return void
     * Gets all errors from the session variable named 'form_errors' and adds them to the form.
     */
    public function addFormErrorsFromPreviousSubmittedDataIfExists(FormInterface $form): void
    {
        $formErrors = $this
            ->session
            ->remove(
                name: 'form_errors',
            );

        if (
            is_array($formErrors) === false
            ||
            count($formErrors) === 0
        ) {
            return;
        }

        foreach ($formErrors as $formError) {
            [
                'message' => $message,
                'origin' => $origin
            ] = $formError;

            $form
                ->get(
                    name: $origin
                )
                ->addError(
                    error: new FormError(
                        message: $message
                    )
                );
        }
    }
}
